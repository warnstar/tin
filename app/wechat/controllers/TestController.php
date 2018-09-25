<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2018/9/24
 * Time: 15:42
 */
namespace app\wechat\controllers;

use app\common\helpers\ApiResponse;
use app\common\models\Test;
use Tin\Controller;

class TestController extends Controller
{
    public function home()
    {
        $id = $this->request->getQueryParam('id');
        $test = Test::getOneById($id);

        $data = $test->toArray();

        $data['questions'] = $test->questions;

        return ApiResponse::success($data);
    }

    public function userAnswer()
    {

    }

    public function result()
    {

    }
}