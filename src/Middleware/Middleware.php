<?php
/**
 * This file is part of Tin.
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
}
