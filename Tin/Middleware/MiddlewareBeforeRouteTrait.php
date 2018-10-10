<?php
/**
 * This file is part of Tin.
 */
namespace Tin\Middleware;

trait MiddlewareBeforeRouteTrait
{
    /**
     * @var $middlewareBeforeRoute MiddlewareHandle[]
     */
    public $middlewareBeforeRoute;

    /**
     * @param mixed ...$middleware
     * @return self
     */
    public function addMiddlewareBeforeRoute(...$middleware)
    {
        $args = func_get_args();
        foreach ($args as $k => $midClass) {
            $mid = new $midClass;
            if ($mid instanceof Middleware) {
                $this->middlewareBeforeRoute[$midClass] = $mid;
            } else {
                printConsole('Middleware type is invalidity');
                exit(1);
            }
        }

        return $this;
    }

    /**
     * 用于 call_user_func 处理
     * @return array
     */
    public function getMiddlewareHandlesBeforeRoute()
    {
        $arr = [];
        if (is_array($this->middlewareBeforeRoute)) {
            foreach ($this->middlewareBeforeRoute as $k => $v) {
                $arr[$k] = [
                $v,
                'handle'
            ];
            }
        }
        return $arr;
    }
}
