<?php
/**
 * This file is part of Tin.
 */
namespace app\wechat\controllers;

use app\common\helpers\ApiResponse;
use app\common\models\TestUserAnswer;
use app\common\models\User;
use Tin\Controller;
use \Tin;

class ConfigController extends Controller
{
    public function common()
    {
        $data['service_wechat'] = [
            'title' => '七十二物候健康指南',
            'qrcode_url' => 'https://72ou.oss-cn-beijing.aliyuncs.com/2018-10-14/5bc30bd4b01c0.jpg',
        ];

        return ApiResponse::success($data);
    }
}
