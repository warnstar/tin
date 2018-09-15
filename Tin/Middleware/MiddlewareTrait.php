<?php
/**
 * This file is part of Tin.
 */
namespace Tin\Middleware;

trait MiddlewareTrait
{
    /**
     * @var $middleware MiddlewareHandle[]
     */
    public $middleware;

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
     * 用于 call_user_func 处理
     * @return array
     */
    public function getMiddlewareHandles()
    {
        $arr = [];
        if (is_array($this->middleware)) {
            foreach ($this->middleware as $k => $v) {
                $arr[$k] = [
                $v,
                'handle'
            ];
            }
        }
        return $arr;
    }
}
