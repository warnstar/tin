<?php
/**
 * This file is part of Tin.
 */
namespace app\wechat\controllers;

use app\common\helpers\ApiResponse;
use Tin\Controller;
use Tin\Tin;

class AccountController extends Controller
{
    public function minaLogin()
    {
        $code = $this->request->getQueryParam('code');
        if (!$code) {
            return ApiResponse::error("PARAMS", '请传入小程序code');
        }
        $res = Tin::$app->wechat->mina()->auth->session($code);

        return ApiResponse::success($res);
    }
}
