<?php
/**
 * This file is part of Tin.
 */

$r = new \Tin\Router();

// 全局cros中间件
$r->addMiddlewareBeforeRoute(\app\common\middlewares\CROSMiddleware::class);

$r->get('/', \app\admin\controllers\IndexController::class . '@index');

# 后台登陆
$r->post('/admin/account/login', \app\admin\controllers\AccountController::class . '@login');


$r->group('/admin', function(\Tin\Router $r) {
   $r->get('/admin-info', \app\admin\controllers\AdminController::class . '@detail')
   ->addMiddleware(\app\admin\middleware\AuthTokenMiddleware::class);
});

$r->group('/admin', function(\Tin\Router $r) {
   $r->group('/test', function(\Tin\Router $r) {
       $r->get('/index', \app\admin\controllers\TestController::class. '@index');
       $r->get('/form', \app\admin\controllers\TestController::class. '@form');
       $r->get('/delete', \app\admin\controllers\TestController::class . '@delete');
   });
});

# 后台首页
$r->get('/admin/home', \app\admin\controllers\HomeController::class . '@index')
    ->addMiddleware(\app\admin\middleware\AuthTokenMiddleware::class);

return $r;
