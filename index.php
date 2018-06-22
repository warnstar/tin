<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18-6-21
 * Time: 下午6:05
 */
require_once "vendor/autoload.php";

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/users', 'get_all_users_handler');
    // {id} must be a number (\d+)
    $r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
    // The /{title} suffix is optional
    $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});

$http = new swoole_http_server("0.0.0.0", 80);

$http->on("start", function ($server) {
    echo "Swoole http server is started at http://0.0.0.0:80\n";
});

$http->on("request", function ($request, $response) use ($dispatcher) {
    $response->header("Content-Type", "text/plain");

    $request_method = $request->server['request_method'];
    $request_uri = $request->server['request_uri'];

    $httpMethod =$request_method;
    $uri = $request_uri;

    if (false !== $pos = strpos($uri, '?')) {
        $uri = substr($uri, 0, $pos);
    }
    $uri = rawurldecode($uri);

    $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

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

});

$http->start();