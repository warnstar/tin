<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2018/9/24
 * Time: 15:42
 */
namespace app\wechat\controllers;

use app\common\helpers\ApiResponse;
use app\common\models\Desire;
use Tin\Controller;

class DesireController extends Controller
{
    public function index()
    {
        $res = Desire::query()->get();

        return ApiResponse::success($res);
    }

    public function userSave()
    {

    }
}