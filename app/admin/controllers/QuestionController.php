<?php
/**
 * This file is part of Tin.
 */
namespace app\admin\controllers;

use app\common\helpers\ApiResponse;
use app\common\models\Question;
use Tin\Controller;

class QuestionController extends Controller
{
    public function index()
    {
        $params = $this->request->getQueryParams();

        $res = (new Question())->search($params);

        return ApiResponse::success($res);
    }


    public function detail()
    {
        $id = $this->request->getQueryParam('id');
        $one = Question::getOneById($id);

        $one->items;
        return ApiResponse::success($one);
    }

    public function form()
    {
        $id = $this->request->getParsedBodyParam('id');

        $one = Question::getOneById($id);
        if (!$one) {
            $one = new Question();
        }

        if ($this->request->getMethod() == 'POST') {
            $post  = $this->request->getParsedBody();

            if ($one->fill($post)) {
                if ($one->save()) {
                    return ApiResponse::success($one);
                }
            }
        }

        return ApiResponse::success($one);
    }

    public function delete()
    {
        $id = $this->request->getQueryParam('id');
        $one = Question::getOneById($id);

        if ($one) {
            if ($one->delete()) {
                return ApiResponse::success();
            } else {
                return ApiResponse::error('PARAM', '删除失败');
            }
        }

        return ApiResponse::error('PARAM', '删除失败-目标不存在');
    }
}