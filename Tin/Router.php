<?php
/**
 * This file is part of Tin.
 */

namespace Tin;

use FastRoute;
use Tin\Http\Request;
use Tin\Http\StatusCode;

class Router
{
    /**
     * @var Route[] $routes
     */
    private $routes = [];

    private $curRouteGroup;
    /**
     * Route counter incrementer
     * @var int
     */
    protected $routeCounter = 0;

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
        foreach ($this->routes as $v) {
            echo sprintf("\t\033[0;34m %s \t\033[0;32m%s \033[0m \t%s\n", $v->getMethod(), $v->getRoute(), $v->getCallable());
        }
    }

    /**
     * Add route
     *
     * @param  string[] $method Array of HTTP methods
     * @param  string   $pattern The route pattern
     * @param  callable $handler The route callable
     *
     * @return Route
     */
    public function map($method, $pattern, $handler)
    {
        if (!is_string($pattern)) {
            throw new \Exception('Route pattern must be a string');
        }

        // Add route
        $route = $this->createRoute($method, $pattern, $handler);
        $this->routes[$route->getIdentifier()] = $route;
        $this->routeCounter++;

        return $route;
    }

    /**
     * Create a new Route object
     *
     * @param  string $method of HTTP methods
     * @param  string   $pattern The route pattern
     * @param  callable $callable The route callable
     *
     * @return Route
     */
    protected function createRoute($method, $pattern, $callable)
    {
        $route = new Route($method, $pattern, $callable, $this->curRouteGroup, $this->routeCounter);
        
        return $route;
    }

    /**
     * @param string $route
     * @param string $handle
     */
    public function get(string $route, string $handle)
    {
        return $this->map("GET", $route, $handle);
    }

    /**
     * @param string $route
     * @param string $handle
     */
    public function post(string $route, string $handle)
    {
        return $this->map("POST", $route, $handle);
    }

    /**
     * @param string $route
     * @param callable $callback
     */
    public function group(string $prefix, callable $callback)
    {
        $previousGroupPrefix = $this->curRouteGroup;
        $this->curRouteGroup = $previousGroupPrefix . $prefix;
        $callback($this);
        $this->curRouteGroup = $previousGroupPrefix;
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
                    $r->addRoute($v->getMethod(), $v->getRoute(), $v->getIdentifier());
                }
            }
        });

        return $dispatcher;
    }

    /**
     * @param Request  $request
     */
    public function execute(&$request)
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
                // ... 405 Method Not Allowed
                $request->response->withStatus(StatusCode::HTTP_METHOD_NOT_ALLOWED);
                break;
            case FastRoute\Dispatcher::FOUND:
                $routeIdentified = $routeInfo[1];
                $vars = $routeInfo[2];

                $route = $this->getRouteByIdentified($routeIdentified);

                if (!$route) {
                    throw new \Exception(sprintf("目标路由不存在：%s", $routeIdentified));
                }

                $data = $route->run($vars, $request);
                break;
            default:
                $data = 'not fund';
        }

        $request->response->write($data);
        $request->response->end();
    }

    /**
     * @param $identified
     * @return null|Route
     */
    public function getRouteByIdentified($identified)
    {
        return isset($this->routes[$identified]) ? $this->routes[$identified] : null;
    }
}
