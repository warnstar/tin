<?php
/**
 * This file is part of Tin.
 */

namespace Tin\Base;

use FastRoute;
use Tin\Http\Request;
use Tin\Http\StatusCode;

class Router
{
    /**
     * @var array $routes
     */
    private static $routes = [];

    /**
     * @param string $route
     * @param string $handle
     * @param array $middlewares
     */
    public static function get(string $route, string $handle, $middlewares = [])
    {
        array_push(self::$routes, ['GET', $route, $handle, $middlewares]);
    }

    /**
     * @param string $route
     * @param string $handle
     * @param array $middlewares
     */
    public static function post(string $route, string $handle, $middlewares = [])
    {
        array_push(self::$routes, ['POST', $route, $handle, $middlewares]);
    }

    /**
     * @var FastRoute\Dispatcher $dispatcher
     */
    private static $dispatcher;

    /**
     * @return FastRoute\Dispatcher
     */
    public static function getDispatcher()
    {
        if (!self::$dispatcher) {
            self::$dispatcher = self::buildDispatcher(self::$routes);
        }

        return self::$dispatcher;
    }

    /**
     * @param $router
     * @return FastRoute\Dispatcher
     */
    protected static function buildDispatcher($router)
    {
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
    public static function execute($request)
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

        $routeInfo = self::getDispatcher()->dispatch($httpMethod, $uri);

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
