<?php
/**
 * This file is part of Tin.
 */
require_once __DIR__ .  '/../vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv(dirname(__DIR__));
$dotenv->load();

// Tin
require_once __DIR__ . '/../tin/Tin.php';

require_once __DIR__ . '/../app/boot.php';


$r = new \Tin\Base\Router();


$r->get('/users', \app\controllers\IndexController::class . '@index');
$r->get('/index/{id:\d+}', \app\controllers\IndexController::class . '@index');
$r->post('/index', \app\controllers\IndexController::class . '@create');

$r->group('/test', function (\Tin\Base\Router $r) {
    $r->get('/mid', \app\controllers\TestController::class . '@mid');
});

(new \Tin\Base\Application())->run($r);
