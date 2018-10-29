<?php
/**
 * This file is part of Tin.
 */

$r = new \Tin\Router();

// 全局cros中间件
$r->addMiddlewareBeforeRoute(\app\common\middlewares\CROSMiddleware::class);
$r->addMiddlewareBeforeRoute(\app\common\middlewares\RequestLogMiddleware::class);

$r->get('/', \app\admin\controllers\IndexController::class . '@index');

$r->post('/post', \app\admin\controllers\IndexController::class . '@create')
    // 单路由中间件
    ->addMiddleware(\app\admin\middleware\AuthTokenMiddleware::class);

$r->group('/aa', function(\Tin\Router $r) {
    $r->get('/index', \app\admin\controllers\IndexController::class . '@index');

    // group中间件设置
})->addMiddleware(\app\admin\middleware\AuthTokenMiddleware::class);

return $r;
