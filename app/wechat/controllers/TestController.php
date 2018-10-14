<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2018/9/24
 * Time: 15:42
 */
namespace app\wechat\controllers;

use app\common\helpers\ApiResponse;
use app\common\models\Question;
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
        if ($data['questions']) {
            foreach ($data['questions'] as $k => $one) {
                if ($one->type == Question::TYPE_SELECT) {
                    $data['questions'][$k]['items'] = $one->items;
                }
            }
        }

        return ApiResponse::success($data);
    }

    public function userAnswer()
    {

    }

    public function result()
    {

    }
}