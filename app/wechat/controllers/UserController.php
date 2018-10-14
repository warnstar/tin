<?php
/**
 * This file is part of Tin.
 */
namespace app\wechat\controllers;

use app\common\helpers\ApiResponse;
use app\common\models\TestUserAnswer;
use app\common\models\User;
use Tin\Controller;
use \Tin;

class UserController extends Controller
{
    public function info()
    {
        $data['id'] = $this->request->user->identity->id;
        $data['nickname'] = $this->request->user->identity->nickname;
        $data['avatar'] = $this->request->user->identity->avatar;

        // 最后一次测试时间
        $last_test_answer = TestUserAnswer::getLastOneByUser($data['id']);
        $data['last_test_time'] = $last_test_answer ? $last_test_answer->created_at : null;

        // 用户角色
        $data['is_teacher'] = $this->request->user->identity->is_teacher;

        return ApiResponse::success($data);
    }
}
