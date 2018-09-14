<?php
/**
 * This file is part of Tin.
 */
namespace app\admin\controllers;

use app\admin\model\Admin;
use app\common\helpers\ApiResponse;
use Tin\Controller;

class LoginController extends Controller
{
    public function login()
    {
        $username = $this->request->getParsedBodyParam('username');
        $password = $this->request->getParsedBodyParam('password');

        $admin = Admin::getOneByUserName($username);

        if (!$admin) {
            return ApiResponse::error('PARAM', '账户不存在');
        }

        $token = $admin->loginByPassword($password);
        if ($token) {
            return ApiResponse::success($token);
        } else {
            return ApiResponse::error('PARAM', $admin->getErrorFirstString());
        }
    }
}
