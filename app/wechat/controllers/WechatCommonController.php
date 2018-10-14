<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2018/9/24
 * Time: 15:42
 */
namespace app\wechat\controllers;

use app\common\helpers\ApiResponse;
use Tin\Controller;

class WechatCommonController extends Controller
{
    public function submitFormId()
    {
        return ApiResponse::success([]);
    }
}