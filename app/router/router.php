<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/9/12
 * Time: 20:25
 */

$r = new \Tin\Router();

$r->addMiddleware(\app\common\middlewares\CROSMiddleware::class);

$r->get('/', \app\admin\controllers\IndexController::class . '@index');

# 后台登陆
$r->post('/admin/login', \app\admin\controllers\LoginController::class . '@login');


return $r;