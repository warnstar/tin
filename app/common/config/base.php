<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2018/10/24
 * Time: 23:12
 */

// 数据库
$components['capsule'] = \app\common\components\DbComponent::getInstance();

// 路由
$components['router'] =  require(APP_PATH . '/router/router.php');

// http服务器
$components['server'] = new \Tin\HttpServer([
    'swooleConfig' => [
        'host' => getenv('swoole.host'),
        'port' => getenv('swoole.port'),
        'worker_num' => getenv('swoole.worker_num'),
        'package_max_length' => getenv('swoole.package_max_length'),
    ]
]);

$config['components'] = $components;

return $config;
