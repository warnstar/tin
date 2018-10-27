<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2018/10/24
 * Time: 23:12
 */

$components['router'] =  require(APP_PATH . '/router/router.php');
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
