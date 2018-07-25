<?php
/**
 * This file is part of Tin.
 */

namespace Tin\Base;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Tin\Exception\HttpInterruptException;
use Tin\Http\Request;
use Tin;

class Application
{
    /**
     * @var \Swoole\Http\Server $swServer
     */
    private static $swServer;

    /**
     * @var $router Router
     */
    public $router;

    public static function swServer()
    {
        return self::$swServer;
    }

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

    public function initHttpServer()
    {
        $http = new \Swoole\Http\Server(env('SWOOLE_HTTP_SERVER_ADDR', '0.0.0.0'), env('SWOOLE_HTTP_LISTEN_PORT', 80));

        // 设置全局swoole server变量
        self::$swServer = &$http;

        $http->set([
            'worker_num' => env('SWOOLE_HTTP_WORKER_NUM', 4),
            'daemonize' => env('SWOOLE_HTTP_IS_DAEMON', false),
            'backlog' => 128,
            'enable_static_handler' => true,
            'document_root' => APP_ROOT . '/public'
        ]);

        $http->on('start', function ($server) {
            echo "Tin已启动http服务器，监听80端口\n";

            // 开启热加载
            if (getenv('RUN_ENV') == 'DEV') {
                Tin\Watcher::run([
                    APP_ROOT . '/tin',
                    APP_ROOT . '/app'
                ]);
            }
        });

        $http->on('ManagerStart', function (\Swoole\Http\Server $server) {
            echo 'ManagerStart: ' . PHP_EOL . PHP_EOL;
        });

        $http->on('WorkerStart', function (\Swoole\Http\Server $server, int $workerId) {
            // 通过重新加载外部文件来重载代码和释放之前占用的内存
        });

        $http->on('request', function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) {
            $this->processRequest($this->router, Request::createFromSwoole($request, $response));
        });

        $http->start();
    }

    public function run(Router $router)
    {
        $this->initRouter($router);


        $this->initHttpServer();
    }

    public function initRouter(Router $router)
    {
        $this->router = $router;
        $this->router->init();
    }

    /**
     * @param Request $request
     */
    public function processRequest(Router $router, Request $request)
    {
        try {
            $router->execute($request);
        } catch (HttpInterruptException $e) {
            $request->response->end('HttpInterruptException');
        } catch (\Exception $e) {
            throw $e;
            $request->response->end(json_encode($e, true));
        }
    }
}
