<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18-6-22
 * Time: 下午4:57
 */

namespace tin\base;

use FastRoute;

class Router
{
    /**
     * @var FastRoute\simpleDispatcher $dispatcher
     */
    public static $dispatcher;

    public static function register($router)
    {
        $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) use ($router) {
            if ($router) foreach ($router as $v) {
                if (!is_array($v) || count($v) != 3) {
                    throw new Exception("请以以下格式传入路由配置：[httpMethod, route, handler]");
                }
            }
            /**
             * @var FastRoute\RouteCollector  $r
             */
            $r->addRoute('GET', '/users', 'get_all_users_handler');
            // {id} must be a number (\d+)
            $r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
            // The /{title} suffix is optional
            $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
        });

        self::$dispatcher = $dispatcher;
    }
    /**
     * @param \Swoole\Http\Request  $request
     * @param \Swoole\Http\Response $response
     */
    public static function execute($request, $response)
    {
        $response->header("Content-Type", "text/plain");

        $request_method = $request->server['request_method'];
        $request_uri = $request->server['request_uri'];

        $httpMethod =$request_method;
        $uri = $request_uri;

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = self::$dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                $response->end(json_encode("not fund"));
                return;
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                // ... call $handler with $vars
                break;
        }
    }
}