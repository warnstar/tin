<?php
/**
 * This file is part of Tin.
 */

namespace Tin;

use FastRoute;
use Tin\Http\Request;
use Tin\Http\StatusCode;
use Tin\Middleware\Middleware;

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

    /**
     * @var Middleware[]
     */
    protected $middleware = [];

    public function __construct()
    {
    }

    public function init()
    {
        $this->getDispatcher();
        $this->printRoute();
    }

    /**
     * @param mixed ...$middleware
     * @return self
     */
    public function addMiddleware(...$middleware)
    {
        $args = func_get_args();
        foreach ($args as $k => $midClass) {
            $mid = new $midClass;
            if ($mid instanceof Middleware) {
                $this->middleware[$midClass] = $mid;
            } else {
                printConsole('Middleware type is invalidity');
                exit(1);
            }
        }

        return $this;
    }

    /**
     * @return Middleware[]
     */
    public function getMiddleware()
    {
        return $this->middleware;
    }

    /**
     * 用于 call_user_func 处理
     * @return array
     */
    public function getMiddlewareHandles()
    {
        $arr = [];
        foreach ($this->middleware as $k => $v) {
            $arr[$k] = [
                $v,
                'handle'
            ];
        }
        return $arr;
    }

    /**
     * @param string $routeStr
     * @return null|Route
     */
    public function getRouteByPattern(string $pattern)
    {
        if ($pattern) {
            foreach ($this->routes as $v) {
                if ($v->getRoute() == $pattern) {
                    return $v;
                }
            }
        }

        return null;
    }

    public function printRoute()
    {
        echo "\033[1;33m 已经注册的路由如下： \033[0m \n";
        foreach ($this->routes as $v) {
            $route = str_pad($v->getRoute(), 25, ' ');

            list($class, $classMethod) = explode('@', $v->getCallable());

            echo sprintf("\t\033[0;34m %s \t\033[1;37m %s \t\033[0;32m%s \033[0;37m%s\n \e[0m ", $v->getMethod(), $route, $class, $classMethod);
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

        // 检查路由是否合法
        if ($this->getRouteByPattern($route->getRoute())) {
            throw  new \Exception(sprintf('当前路由已注册：%s', $route->getRoute()));
        }

        return $route;
    }

    /**
     * @param string $route
     * @param string $handle
     */
    public function get(string $route, string $handle)
    {
        return $this->map('GET', $route, $handle);
    }

    /**
     * @param string $route
     * @param string $handle
     */
    public function post(string $route, string $handle)
    {
        return $this->map('POST', $route, $handle);
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
     * 一次http请求的地点
     *
     * @param Request  $request
     */
    public function execute(&$request)
    {
        $request_method =$request->getMethod();
        $request_uri = $request->getUri()->getPath();

        printConsole(sprintf('%s Fd=%s %s %s', date('Y-m-d H:i:s'), $request->getFd(), $request_method, $request_uri));

        // CROS 处理
        $request->response->withHeader('Access-Control-Allow-Origin', '*');
        $request->response->withHeader("Access-Control-Allow-Methods", "GET,POST,PUT,PATCH,DELETE,OPTIONS");
        $request->response->withHeader("Access-Control-Allow-Headers", "authorization, origin, content-type, accept, X-Request-Token");
        $request->response->withHeader("Allow", "HEAD,GET,POST,PUT,PATCH,DELETE,OPTIONS");
        $request->response->withHeader("Content-Type", "application/json");
        if ($request->getMethod() == 'OPTIONS') {
            $request->endShow('');
        }

        $httpMethod =$request_method;
        $uri = $request_uri;

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $this->getDispatcher()->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found

                $data = 'not fund';
                $request->response->write($data);
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
                    throw new \Exception(sprintf('目标路由不存在：%s', $routeIdentified));
                }

                /**
                 * 构造中间件队列
                 */
                $handles = array_merge($this->getMiddlewareHandles(), $route->getMiddlewareHandles());

                /**
                 * 中间件调度处理
                 */
                (new \Tin\Middleware\Processor())
                    ->send($request)
                    ->through($handles)
                    ->then(function ($request) use ($vars, $route) {
                        $data = $route->run($vars, $request);
                        $request->response->write($data);
                    });
                break;
            default:
            $data = 'not fund';
            $request->response->write($data);
        }

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
