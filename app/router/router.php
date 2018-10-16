<?php
/**
 * This file is part of Tin.
 */

$r = new \Tin\Router();

// 全局cros中间件
$r->addMiddlewareBeforeRoute(\app\common\middlewares\CROSMiddleware::class);
$r->addMiddlewareBeforeRoute(\app\common\middlewares\RequestLogMiddleware::class);

$r->get('/', \app\admin\controllers\IndexController::class . '@index');

# 后台登陆
$r->post('/admin/account/login', \app\admin\controllers\AccountController::class . '@login');


$r->group('/admin', function (\Tin\Router $r) {
    $r->post('/storage/upload', \app\common\components\storage\controllers\UploadController::class. '@upload');

    # 后台首页
    $r->get('/home', \app\admin\controllers\HomeController::class . '@index');

    // 后台用户信息
    $r->get('/admin-info', \app\admin\controllers\AdminController::class . '@detail')
        ->addMiddleware(\app\admin\middleware\AuthTokenMiddleware::class);

    // 测评相关
    $r->group('/test', function (\Tin\Router $r) {
        $r->get('/index', \app\admin\controllers\TestController::class. '@index');
        $r->post('/save', \app\admin\controllers\TestController::class. '@form');
        $r->get('/delete', \app\admin\controllers\TestController::class . '@delete');
    });

    // 题目相关
    $r->group('/question', function (\Tin\Router $r) {
        $r->get('/index', \app\admin\controllers\QuestionController::class. '@index');
        $r->get('/detail', \app\admin\controllers\QuestionController::class. '@detail');
        $r->post('/save', \app\admin\controllers\QuestionController::class. '@form');
        $r->get('/delete', \app\admin\controllers\QuestionController::class . '@delete');
    });

    // 测试愿望
    $r->group('/desire', function (\Tin\Router $r) {
        $r->get('/index', \app\admin\controllers\DesireController::class. '@index');
        $r->post('/save', \app\admin\controllers\DesireController::class. '@form');
        $r->get('/delete', \app\admin\controllers\DesireController::class . '@delete');
    });
})->addMiddleware(\app\admin\middleware\AuthTokenMiddleware::class);


# 微信文件上传接口
$r->post('/wechat/storage/upload', \app\common\components\storage\controllers\UploadController::class. '@upload')
->addMiddleware(\app\wechat\middleware\AuthTokenMiddleware::class);

// 微信相关接口
$r->get('/wechat/config', \app\wechat\controllers\ConfigController::class. '@common');
$r->get('/wechat/test/home', \app\wechat\controllers\TestController::class. '@home');
$r->post('/wechat/account/mina-login', \app\wechat\controllers\AccountController::class . '@minaLogin');

$r->group('/wechat', function (\Tin\Router $r) {
    // 测评相关
    $r->group('/test', function (\Tin\Router $r) {
        $r->post('/confirm-answer', \app\wechat\controllers\TestController::class. '@userAnswer');
        $r->get('/result', \app\wechat\controllers\TestController::class . '@result');
    });

    // 愿望
    $r->get('/desire/hot', \app\wechat\controllers\DesireController::class . '@index');
    $r->post('/desire', \app\wechat\controllers\DesireController::class . '@userSave');

    // 用户
    $r->get('/user/info', \app\wechat\controllers\UserController::class . '@info');

    // 微信公共
    $r->group('/wechat-common', function (\Tin\Router $r) {
        $r->post('/form-id', \app\wechat\controllers\WechatCommonController::class . '@submitFormId');
    });

    // 教师端
    $r->group('/teacher', function (\Tin\Router $r) {
        $r->get('/answers', \app\wechat\controllers\TeacherAnswerController::class . '@answers');
        $r->get('/answer-detail', \app\wechat\controllers\TeacherAnswerController::class . '@answerDetail');

        $r->post('/result', \app\wechat\controllers\TeacherAnswerController::class . '@result');
    });
})->addMiddleware(\app\wechat\middleware\AuthTokenMiddleware::class);

return $r;
