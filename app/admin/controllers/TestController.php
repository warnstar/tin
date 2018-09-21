<?php
/**
 * This file is part of Tin.
 */
namespace app\admin\controllers;

use app\common\helpers\ApiResponse;
use app\common\models\Test;
use Tin\Controller;

class TestController extends Controller
{
    public function index()
    {
        $params = $this->request->getQueryParams();

        $res = (new Test())->search($params);

        return ApiResponse::success($res);
    }


    public function form()
    {
        $id = $this->request->getParsedBodyParam('id');

        $test = Test::getOneById($id);
        if (!$test) {
            $test = new Test();
            $test->cover = '' ;
        }

        if ($this->request->getMethod() == 'POST') {
            $post  = $this->request->getParsedBody();

            if ($test->fill($post)) {
                if ($test->save()) {
                    return ApiResponse::success($test);
                }
            }
        }

        return ApiResponse::success($test);
    }

    public function delete()
    {
        $id = $this->request->getQueryParam('id');
        $test = Test::getOneById($id);

        if ($test) {
            if ($test->delete()) {
                return ApiResponse::success();
            } else {
                return ApiResponse::error('PARAM', '删除失败');
            }
        }

        return ApiResponse::error('PARAM', '删除失败-目标不存在');
    }
}
