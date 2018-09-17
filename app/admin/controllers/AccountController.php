<?php
/**
 * This file is part of Tin.
 */
namespace app\admin\controllers;

use app\admin\model\Admin;
use app\common\helpers\ApiResponse;
use Tin\Controller;

class AccountController extends Controller
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

        $data['access_token'] = $token;
        if ($token) {
            return ApiResponse::success($data);
        } else {
            return ApiResponse::error('PARAM', $admin->getErrorFirstString());
        }
    }
}
