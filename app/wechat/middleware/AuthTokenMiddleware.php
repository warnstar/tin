<?php
/**
 * This file is part of Tin.
 */
namespace app\wechat\middleware;

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
        $targetUser = \app\common\models\User::getOneByToken($token);

        if (!$targetUser) {
            $request->endShow(ApiResponse::error('UN_AUTH'));
        }

        $user = new User();
        $user->loginByIdentity($targetUser);

        $request->user = $user;
    }
}
