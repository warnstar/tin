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
use app\common\models\TestUserAnswer;
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

        $data = $answer;
        $data['result'] = json_decode($answer->result, true);
        $data['answers'] = json_decode($answer->answers, true);
        // 用户信息
        $data['userInfo']['nickname'] = $answer->user->nickname;
        $data['userInfo']['avatar'] = $answer->user->avatar;

        // 测试
        $data['test'] = $answer->test;
        $data['test']['questions'] = $answer->test->questions;
        if ($data['test']['questions']) {
            foreach ($data['test']['questions'] as $k => $one) {
                if ($one->type == Question::TYPE_SELECT) {
                    $data['test']['questions'][$k]['items'] = $one->items;
                }
            }
        }

        return ApiResponse::success($data);
    }

    public function result()
    {
        $post = $this->request->getParsedBody();
        
        $data = $post;
        return ApiResponse::success($data);
    }
}