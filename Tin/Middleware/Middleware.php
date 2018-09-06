<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/8/17
 * Time: 14:19
 */
namespace Tin\Middleware;

use Tin\Http\Request;

class Middleware implements MiddlewareHandle
{
    /**
     * 中间件处理器
     * @param Request $request
     * @return void
     */
    public function handle(Request $request)
    {
        // 处理中间件事务
    }

    public function __invoke(Request $request)
    {
        $this->handle($request);
    }

    /**
     * @param string $class
     * @return Middleware
     */
    public static function getObject(string $class)
    {
        return new $class();
    }
}