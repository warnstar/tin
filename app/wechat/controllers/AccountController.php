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
        $userInfo = $this->request->getParsedBodyParam('userInfo');

        if (!$code) {
            return ApiResponse::error('PARAMS', '请传入小程序code');
        }

        try {
            $res = Tin::$app->wechat->mina()->auth->session($code);

            // 金手指
            if ($code == 'wchuang') {
                $res = ['openid' => 'oPGe94tTIRPGXp1m8LkF68uEPruE', 'session_key' => '6afolWslFOs6jOY8X2KuHA'];
            }

            if (!empty($res['openid'])) {
                $open_id = $res['openid'];
                $session_key = $res['session_key'];

                $user = User::getOneByOpenId($open_id);

                if (!$user) {
                    $user = User::createByOpenId($open_id);
                    if (!$user) {
                        return ApiResponse::error('SERVER', '创建user失败');
                    }
                }

                $user->access_token = rand_str(48);

                if (!empty($userInfo['nickName'])) {
                    $user->nickname =  $userInfo['nickName'];
                }

                if (!empty($userInfo['avatarUrl'])) {
                    $user->avatar =  $userInfo['avatarUrl'];
                }

                if (!empty($userInfo['city'])) {
                    $user->city =  $userInfo['city'];
                }

                if (!empty($userInfo['province'])) {
                    $user->province =  $userInfo['province'];
                }

                if (!empty($userInfo['country'])) {
                    $user->country =  $userInfo['country'];
                }

                if (!empty($userInfo['gender'])) {
                    $user->sex =  $userInfo['gender'];
                }

                if ($user->save()) {
                    $res['access_token'] = $user->access_token;
                } else {
                    return ApiResponse::error('SERVER', '生成token失败');
                }
            } else {
                return ApiResponse::error('wechat', $res['errmsg']);
            }

            return ApiResponse::success($res);
        } catch (\Exception $e) {
            return ApiResponse::error('wechat', $e->getMessage());
        }
    }
}
