<?php
/**
 * This file is part of Tin.
 */

namespace Tin\Base;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Tin\Exception\HttpInterruptException;
use Tin\Http\Request;

class Application
{
    /**
     * Container
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * Create new application
     *
     * @param ContainerInterface|array $container Either a ContainerInterface or an associative array of app settings
     * @throws InvalidArgumentException when no container is provided that implements ContainerInterface
     */
    public function __construct($container = [])
    {
        if (is_array($container)) {
            $container = new Container($container);
        }
        if (!$container instanceof ContainerInterface) {
            throw new InvalidArgumentException('Expected a ContainerInterface');
        }
        $this->container = $container;
    }

    /**
     * Calling a non-existant method on App checks to see if there's an item
     * in the container that is callable and if so, calls it.
     *
     * @param  string $method
     * @param  array $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        if ($this->container->has($method)) {
            $obj = $this->container->get($method);
            if (is_callable($obj)) {
                return call_user_func_array($obj, $args);
            }
        }

        throw new \BadMethodCallException("Method $method is not a valid method");
    }



    public function run($config = [])
    {
        $http = new \Swoole\Http\Server(env("SWOOLE_HTTP_SERVER_ADDR", '0.0.0.0'), env("SWOOLE_HTTP_LISTEN_PORT", 80));

        $http->set([
            'worker_num' => env("SWOOLE_HTTP_WORKER_NUM", 4),
            'daemonize' => env("SWOOLE_HTTP_IS_DAEMON", false),
            'backlog' => 128,
        ]);

        $http->on('start', function ($server) {
            echo "Tin已启动http服务器，监听80端口\n";
        });

        $http->on('request', function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) {
            $this->process(Request::createFromSwoole($request, $response));
        });

        $http->start();
    }

    /**
     * @param Request $request
     */
    public function process(Request $request)
    {
        try {
            Router::execute($request);
        } catch (HttpInterruptException $e) {
            $request->response->end('qwe');
        } catch (\Exception $e) {
        }
    }
}
