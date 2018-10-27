<?php
/**
 * This file is part of Tin.
 */
namespace app\wechat\controllers;

use app\common\helpers\ApiResponse;
use app\common\models\Desire;
use app\common\models\Question;
use app\common\models\TestUserAnswer;
use app\wechat\moduleMessage\messages\TestResultMessage;
use Tin\Controller;

class TeacherAnswerController extends Controller
{
    public function answers()
    {
        $params = $this->request->getQueryParams();

        $res = (new TestUserAnswer())->search($params);

        $data = $res->toArray();
        if ($res) {
            foreach ($res as $k => $v) {
                $data[$k]['user_info']['nickname'] = $v->user->nickname;
                $data[$k]['user_info']['avatar'] = $v->user->avatar;
            }
        }

        return ApiResponse::success($data);
    }

    public function answerDetail()
    {
        $id = $this->request->getQueryParam('id');

        $answer = TestUserAnswer::getOneById($id);
        if (!$answer) {
            return ApiResponse::error('PARAM', '目标测试答案不存在');
        }

        $data = $answer->toArray();
        $data['result'] = json_decode($answer->result, true);
        $data['answers'] = json_decode($answer->answers, true);

        // 用户信息
        $data['user_info']['nickname'] = $answer->user->nickname;
        $data['user_info']['avatar'] = $answer->user->avatar;

        // 用户愿望标签
        $data['user_desire'] = Desire::getUserLast($answer->user_id);

        // 测试
        $data['test'] = $answer->test;
        $data['test']['questions'] = $answer->test->questions;
        if ($data['test']['questions']) {
            foreach ($data['test']['questions'] as $k => $one) {
                if (in_array($one->type, [Question::TYPE_SELECT, Question::TYPE_SELECT_MULTI])) {
                    $data['test']['questions'][$k]['items'] = $one->items;
                }

                // 设置用户的答案
                foreach ($data['answers'] as $kk => $vv) {
                    if ($kk == $one->id) {
                        $data['test']['questions'][$k]['user_value'] = $vv;
                    }
                }
            }
        }

        return ApiResponse::success($data);
    }

    public function result()
    {
        $post = $this->request->getParsedBody();

        $answer_id = isset($post['answer_id']) ? $post['answer_id'] : null;
        $answer = TestUserAnswer::getOneById($answer_id);
        if (!$answer) {
            return ApiResponse::error('PARAM', '目标测试答案不存在');
        }

        $result = [];
        if (!empty($post['result']['conclusion'])) {
            $result['conclusion'] = $post['result']['conclusion'];
        } else {
            return ApiResponse::error('PARAM', '请上传结论');
        }

        if (!empty($post['result']['detail'])) {
            $result['detail'] = $post['result']['detail'];
        } else {
            return ApiResponse::error('PARAM', '请上传结论解读');
        }

        $answer->result = json_encode($result);
        $answer->process_user_id = $this->request->user->id;

        try {
            if ($answer->save()) {

                // 发送模板消息
                (new TestResultMessage())
                    ->setUser($answer->user_id)
                    ->buildData([
                        'test_result' => $result['conclusion'],
                        'test_time' => $answer->created_at->toDateTimeString()
                    ])
                    ->send();

                return ApiResponse::success($answer);
            } else {
                return ApiResponse::error('PARAM', '入库失败');
            }
        } catch (\Exception $e) {
            return ApiResponse::error('SERVER', $e->getMessage());
        }
    }
}
