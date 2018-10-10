<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/9/26
 * Time: 20:08
 */
namespace Tin;

use Tin\Middleware\MiddlewareTrait;

class RouteGroup
{
    /**
     * @var string
     */
    private $path = '';

    /**
     * @var $router Router
     */
    private $router;

    public function __construct($path = '', Router &$router)
    {
        $this->path = $path;
        $this->router = $router;
    }

    /**
     * @param mixed ...$middleware
     */
    public function addMiddleware(...$middleware)
    {
        $args = func_get_args();

        foreach ($this->router->getRoutes() as $k => $route) {
            $routeGroupName = $route->getGroup();

            if (
                $routeGroupName == $this->path
                || $this->path == substr($routeGroupName, 0, strlen($this->path))
            ) {
                foreach ($args as $middleware) {
                    $route->addMiddleware($middleware);
                }
            }
        }
    }
}