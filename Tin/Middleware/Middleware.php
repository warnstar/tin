<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/8/17
 * Time: 14:19
 */
namespace Tin\Middleware;

use Tin\Http\Request;

abstract class Middleware
{
    /**
     * 中间件处理器
     * @param Request $request
     * @return void
     */
    public abstract function handle(Request $request);

    public function __invoke(Request $request)
    {
        $this->handle($request);
    }
}