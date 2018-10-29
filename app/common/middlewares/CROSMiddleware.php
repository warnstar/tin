<?php
/**
 * This file is part of Tin.
 */
namespace app\common\middlewares;

use Tin\Http\Request;
use Tin\Middleware\Middleware;

class CROSMiddleware extends Middleware
{
    public function handle(Request $request)
    {
        // CROS 处理
        $request->response->withHeader('Access-Control-Allow-Origin', '*');
        $request->response->withHeader('Access-Control-Allow-Methods', 'GET,POST,PUT,PATCH,DELETE,OPTIONS');
        $request->response->withHeader('Access-Control-Allow-Headers', 'authorization, origin, content-type, accept, X-Request-Token');
        $request->response->withHeader('Allow', 'HEAD,GET,POST,PUT,PATCH,DELETE,OPTIONS');
        $request->response->withHeader('Content-Type', 'application/json');
        if ($request->getMethod() == 'OPTIONS') {
            $request->endShow('');
        }
    }
}
