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
use app\common\models\TestUserAnswer;
use Tin\Controller;

class TestController extends Controller
{
    public function home()
    {
        $id = $this->request->getQueryParam('id');
        $test = Test::getOneById($id);

        if (!$test) {
            return ApiResponse::error("NOT_FOUND", '对象不存在');
        }

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
        $post = $this->request->getParsedBody();
        
        $test_id = isset($post['test_id']) ? $post['test_id'] : null;
        $test = Test::getOneById($test_id);
        if (!$test) {
            return ApiResponse::error("NOT_FOUND", '测试对象不存在');
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

    }
}