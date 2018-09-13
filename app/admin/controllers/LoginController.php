<?php
/**
 * This file is part of Tin.
 */
namespace app\admin\controllers;

use app\admin\model\Admin;
use Tin\Controller;

class LoginController extends Controller
{
    public function login()
    {
        $post = [
            $this->request->getParams(),
        ];

        $username = $this->request->getParsedBodyParam('username');
        $password = $this->request->getParsedBodyParam('password');

        $a = Admin::getOneByUserName($username);

        if ($a->loginByPassword($password)) {
            return $a;
        } else {
            return ['登陆失败'];
        }
    }
}
