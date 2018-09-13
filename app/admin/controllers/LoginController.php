<?php
/**
 * This file is part of Tin.
 */
namespace app\admin\controllers;

use app\admin\model\Admin;
use RedBeanPHP\R;
use Tin\Controller;

class LoginController extends Controller
{
    public function login()
    {
        try {
            //初始化数据库
            R::setup(
                getenv('db.dsn'),
                getenv('db.username'),
                getenv('db.password')
            );
        } catch (\Exception $e) {
            dump($e);
            file_put_contents('error.json', json_encode($e, true));
        }


        $a = Admin::getOneByUserName('admin');

        return [$a];
    }
}
