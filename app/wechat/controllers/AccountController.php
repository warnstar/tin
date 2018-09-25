<?php
/**
 * This file is part of Tin.
 */
namespace app\wechat\controllers;

use app\common\helpers\ApiResponse;
use app\common\models\User;
use Tin\Controller;
use \Tin;

class AccountController extends Controller
{
    public function minaLogin()
    {
        $code = $this->request->getParsedBodyParam('code');
        if (!$code) {
            return ApiResponse::error("PARAMS", '请传入小程序code');
        }

        try {
//            $res = Tin::$app->wechat->mina()->auth->session($code);
            $res = ['openid' => 'oPGe94tTIRPGXp1m8LkF68uEPruE', 'session_key' => '6afolWslFOs6jOY8X2KuHA'];
            if (!empty($res['openid'])) {
                $open_id = $res['openid'];
                $session_key = $res['session_key'];

                $user = User::getOneByOpenId($open_id);

                return $user;
            } else {
                return ApiResponse::error('wechat', $res['errmsg']);
            }
            return ApiResponse::success($res);
        } catch (\Exception $e) {
            return ApiResponse::error('wechat', $e->getMessage());
        }
    }
}
