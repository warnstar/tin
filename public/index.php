<?php
/**
 * This file is part of Tin.
 */
require_once __DIR__ .  '/../vendor/autoload.php';

require_once __DIR__ . '/../app/boot.php';



$r = new \Tin\Router();

$r->get('/', \app\controllers\IndexController::class . '@index');
$r->get('/index/{id:\d+}', \app\controllers\IndexController::class . '@index');

$r->group('/test', function (\Tin\Router $r) {
    $r->get('/mid', \app\controllers\TestController::class . '@mid');
});

$r->get('to-end',\app\controllers\IndexController::class . '@index');

$components['router'] = $r;

$components['server'] = \Tin\HttpServer::build();
(new \Tin\Tin($components))->run();
