<?php
/**
 * This file is part of Tin.
 */
namespace app\wechat\controllers;

use app\common\helpers\ApiResponse;
use app\common\models\Desire;
use app\common\models\Question;
use app\common\models\Test;
use app\common\models\TestUserAnswer;
use Tin\Controller;

class TestController extends Controller
{
    public function home()
    {
        $id = $this->request->getQueryParam('id');
        $test = Test::getOneById($id);

        if (!$test) {
            return ApiResponse::error('NOT_FOUND', '对象不存在');
        }


        $data = $test->toArray();

        $data['test_count'] = TestUserAnswer::query()->where(['test_id' => $id])->count();

        $data['questions'] = $test->questions;
        if ($data['questions']) {
            foreach ($data['questions'] as $k => $one) {
                if (in_array($one->type, [Question::TYPE_SELECT, Question::TYPE_SELECT_MULTI])) {
                    $data['questions'][$k]['items'] = $one->items;
                }
            }
        }


        return ApiResponse::success($data);
    }

    public function userAnswer()
    {
        $post = $this->request->getParsedBody();
        
        $test_id = isset($post['test_id']) ? $post['test_id'] : null;
        $test = Test::getOneById($test_id);
        if (!$test) {
            return ApiResponse::error('NOT_FOUND', '测试对象不存在');
        }

        if (empty($post['answers'])) {
            return ApiResponse::error('PARAM', '请传入answers');
        }

        $questionsIds = [];
        foreach ($test->questions as $question) {
            $questionsIds[] = $question->id;
        }

        $answers = [];
        foreach ($post['answers'] as $ans) {
            if (!empty($ans['question_id']) && in_array($ans['question_id'], $questionsIds)) {
                if (isset($ans['value'])) {
                    $answers[$ans['question_id']] = $ans['value'];
                }
            }
        }

        if ($answers && count($answers) == count($questionsIds)) {
            $one = new TestUserAnswer();
            $one->user_id = $this->request->user->id;
            $one->test_id = $test_id;
            $one->answers = json_encode($answers, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            try {
                if ($one->save()) {
                    return ApiResponse::success($answers);
                } else {
                    return ApiResponse::error('PARAM', '入库失败');
                }
            } catch (\Exception $e) {
                return ApiResponse::error('PARAM', $e->getMessage());
            }
        } else {
            return ApiResponse::error('PARAM', '请提交有效答案');
        }
    }

    public function result()
    {
        $id = $this->request->getQueryParam('answer_id');

        $answer = TestUserAnswer::getOneById($id);
        if (!$answer) {
            return ApiResponse::error('PARAM', '目标测试答案不存在');
        }

        $data = $answer;
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
                if ($one->type == Question::TYPE_SELECT) {
                    $data['test']['questions'][$k]['items'] = $one->items;
                }
            }
        }

        return ApiResponse::success($data);
    }
}
