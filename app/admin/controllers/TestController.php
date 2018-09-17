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

        
        return ApiResponse::success([]);
    }


    public function form()
    {
        $id = $this->request->getQueryParam('id');

        $test = Test::getOneById($id);
        if (!$test) {
            $test = new Test();
            $test->cover ;
        }

        if ($this->request->getMethod() == 'POST') {
            $post  = $this->request->getParsedBody();

            $test->title = 'wwwwww';
            $test->desc = '123';
            return ApiResponse::success($test->save());
            if ($test->load($post)) {

                if ($test->save()) {
                    return ApiResponse::success(111);
                }
            }
        }



        return ApiResponse::success($test);
    }
}
