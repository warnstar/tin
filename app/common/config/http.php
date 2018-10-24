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

$components['wechat'] = new \app\common\components\Wechat([
    'config' => [
        'mina' => [
            'app_id' => getenv('wechat.mina.appid'),
            'secret' => getenv('wechat.mina.appsecret'),

            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            'log' => [
                'level' => 'debug',
                'file' => APP_PATH.'/runtime/logs/wechat.log',
            ],
        ]
    ],
]);

$config['components'] = $components;

return $config;
