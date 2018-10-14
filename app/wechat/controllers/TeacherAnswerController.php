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
use app\common\models\TestUserAnswer;
use app\common\models\UserWechatFormId;
use Tin\Controller;

class TeacherAnswerController extends Controller
{
    public function answers()
    {
        $params = $this->request->getQueryParams();

        $res = (new TestUserAnswer())->search($params);

        return ApiResponse::success($res);
    }

    public function answerDetail()
    {
        $id = $this->request->getQueryParam('id');

        $answer = TestUserAnswer::getOneById($id);
        if (!$answer) {
            return ApiResponse::error("PARAM", "目标测试答案不存在");
        }


        return ApiResponse::success("");
    }

    public function result()
    {
        $post = $this->request->getParsedBody();
        
        $data = $post;
        return ApiResponse::success($data);
    }
}