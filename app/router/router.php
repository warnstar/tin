<?php
/**
 * This file is part of Tin.
 */

$r = new \Tin\Router();

// 全局cros中间件
$r->addMiddlewareBeforeRoute(\app\common\middlewares\CROSMiddleware::class);

$r->get('/', \app\admin\controllers\IndexController::class . '@index');

$r->group('/admin', function(\Tin\Router $r) {
    $r->post('/storage/upload', \app\common\components\storage\controllers\UploadController::class. '@upload');

    # 后台登陆
    $r->post('/account/login', \app\admin\controllers\AccountController::class . '@login');

    # 后台首页
    $r->get('/home', \app\admin\controllers\HomeController::class . '@index')
        ->addMiddleware(\app\admin\middleware\AuthTokenMiddleware::class);

    // 后台用户信息
    $r->get('/admin-info', \app\admin\controllers\AdminController::class . '@detail')
        ->addMiddleware(\app\admin\middleware\AuthTokenMiddleware::class);

    // 测评相关
   $r->group('/test', function(\Tin\Router $r) {
       $r->get('/index', \app\admin\controllers\TestController::class. '@index');
       $r->get('/form', \app\admin\controllers\TestController::class. '@form');
       $r->post('/save', \app\admin\controllers\TestController::class. '@form');
       $r->get('/delete', \app\admin\controllers\TestController::class . '@delete');
   });
});

$r->group('/api', function(\Tin\Router $r){
    // 测试
    $r->group('/test', function(\Tin\Router $r) {
        $r->get('/home', \app\admin\controllers\TestController::class. '@index');
        $r->post('/confirm-answer', \app\admin\controllers\TestController::class. '@form');
        $r->get('/result', \app\admin\controllers\TestController::class . '@delete');
    });

    // 问题
    $r->group('/question', function(\Tin\Router $r) {
        $r->get('/list', \app\admin\controllers\TestController::class. '@index');
        $r->get('/detail', \app\admin\controllers\TestController::class. '@index');
    });

    // 愿望
    $r->get('/desire/hot', \app\admin\controllers\TestController::class. '@index');
    $r->post('/desire', \app\admin\controllers\TestController::class. '@index');

});

$r->post('/wechat/storage/upload', \app\common\components\storage\controllers\UploadController::class. '@upload');

// 微信相关接口
$r->group('/wechat', function(\Tin\Router $r) {
    $r->post('/account/mina-login', \app\wechat\controllers\AccountController::class . '@minaLogin');
});

return $r;
