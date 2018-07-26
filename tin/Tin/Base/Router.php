<?php
/**
 * This file is part of Tin.
 */

namespace Tin\Base;

use FastRoute;
use Tin\Http\Request;
use Tin\Http\StatusCode;
use Tin\Interfaces\ControllerAbstract;

class Router
{
    /**
     * @var array $routes
     */
    private $routes = [];

    private $curRouteGroup;

    public function __construct()
    {
    }

    public function init()
    {
        $this->getDispatcher();
        $this->printRoute();
    }

    public function printRoute()
    {
        echo "\033[1;33m 已经注册的路由如下： \033[0m \n";
        foreach ($this->routes as $r) {
            echo sprintf("\t\033[0;34m %s \t\033[0;32m%s \033[0m \t%s\n", $r[0], $r[1], $r[2]);
        }
    }

    /**
     * @param string $route
     * @param string $handle
     * @param array $middlewares
     */
    public function get(string $route, string $handle, $middlewares = [])
    {
        $route = $this->curRouteGroup . $route;
        array_push($this->routes, ['GET', $route, $handle, $middlewares]);
    }

    /**
     * @param string $route
     * @param string $handle
     * @param array $middlewares
     */
    public function post(string $route, string $handle, $middlewares = [])
    {
        $route = $this->curRouteGroup . $route;
        array_push($this->routes, ['POST', $route, $handle, $middlewares]);
    }

    /**
     * @param string $route
     * @param callable $callable
     */
    public function group(string $route, callable $callable)
    {
        $this->curRouteGroup = $route;
        $callable($this);
        unset($this->curRouteGroup);
    }

    /**
     * @var FastRoute\Dispatcher $dispatcher
     */
    private $dispatcher;

    /**
     * @return FastRoute\Dispatcher
     */
    public function getDispatcher()
    {
        if ($this->dispatcher == null) {
            $this->dispatcher = $this->buildDispatcher();
        }

        return $this->dispatcher;
    }

    /**
     * @param $router
     * @return FastRoute\Dispatcher
     */
    protected function buildDispatcher()
    {
        $router = $this->routes;

        $dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) use ($router) {
            if ($router) {
                foreach ($router as $v) {
                    $r->addRoute($v[0], $v[1], $v[2]);
                }
            }
        });

        return $dispatcher;
    }

    /**
     * @param Request  $request
     */
    public function execute($request)
    {
        $request_method =$request->getMethod();
        $request_uri = $request->getUri()->getPath();

        printConsole(sprintf('%s Fd=%s %s %s', date('Y-m-d H:i:s'), $request->getFd(), $request_method, $request_uri));

        $httpMethod =$request_method;
        $uri = $request_uri;

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $this->getDispatcher()->dispatch($httpMethod, $uri);

        $data = null;
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found

                $data = 'not fund';
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                $request->response->withStatus(StatusCode::HTTP_METHOD_NOT_ALLOWED);
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                $data = $handler . json_encode($vars);

                list($class, $method) = explode('@', $handler);

                if (class_exists($class)) {
                    /**
                     * @var $class ControllerAbstract
                     */
                    $object = new $class;

                    $object->request = $request;
                    $data = $object->runAction($method, $vars);
                }

                break;
            default:
                $data = 'not fund';
        }

        $request->response->write($data);
        $request->response->end();
    }
}
