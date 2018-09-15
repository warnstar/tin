<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/9/12
 * Time: 20:25
 */

$r = new \Tin\Router();

// 全局cros中间件
$r->addMiddlewareBeforeRoute(\app\common\middlewares\CROSMiddleware::class);

$r->get('/', \app\admin\controllers\IndexController::class . '@index');

# 后台登陆
$r->post('/admin/login', \app\admin\controllers\LoginController::class . '@login');

# 后台首页
$r->get('/admin/home', \app\admin\controllers\HomeController::class . '@index')
    ->addMiddleware(\app\admin\middleware\AuthTokenMiddleware::class);

return $r;