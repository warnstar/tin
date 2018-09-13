<?php
/**
 * This file is part of Tin.
 */
require_once __DIR__ .  '/../vendor/autoload.php';

require_once __DIR__ . '/../app/boot.php';

try {
    //初始化数据库
    \RedBeanPHP\R::setup(
        getenv('db.dsn'),
        getenv('db.username'),
        getenv('db.password')
    );
} catch (\Exception $e) {
    dump($e);
    file_put_contents('error.json', json_encode($e, true));
}

$components['router'] =  require(__DIR__ . '/../app/router/router.php');


$components['server'] = \Tin\HttpServer::build();
(new \Tin\Tin($components))->run();
