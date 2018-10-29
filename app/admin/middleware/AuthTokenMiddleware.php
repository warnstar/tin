<?php
/**
 * This file is part of Tin.
 */
namespace app\admin\middleware;

use app\admin\models\Admin;
use app\common\base\User;
use app\common\helpers\ApiResponse;
use Tin\Http\Request;
use Tin\Middleware\Middleware;

class AuthTokenMiddleware extends Middleware
{
    public function handle(Request $request)
    {
        $token = $request->getHeader('X-Request-Token');

        if (!$token) {
            $request->endShow(ApiResponse::error('UN_AUTH'));
        }

        $token = is_array($token) ? current($token) : $token;
        $admin = Admin::getOneByToken($token);

        if (!$admin) {
            $request->endShow(ApiResponse::error('UN_AUTH'));
        }

        $user = new User();
        $user->loginByIdentity($admin);

        $request->user = $user;
    }
}
