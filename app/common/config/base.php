<?php
/**
 * This file is part of Tin.
 */

$components['capsule'] = \app\common\components\DbComponent::getInstance();
$components['router'] =  require(APP_PATH . '/router/router.php');
$components['server'] = \Tin\HttpServer::build();

$components['wechat'] = new \app\common\components\Wechat([
    'config' => [
        'mina' => [
            'app_id' => getenv("wechat.mina.appid"),
            'secret' => getenv("wechat.mina.appsecret"),

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

//$components['storage'] = new \app\common\components\storage\instance\Qiniu([
//    'accessKey' => getenv('qiniu.access_key'),
//    'accessSecret' => getenv('qiniu.secret_key'),
//    'bucket' => getenv('qiniu.bucket'),
//    'domian' => getenv('qiniu.domain'),
//    'https' => getenv('qiniu.https')
//]);

$components['storage'] = new \app\common\components\storage\instance\AliOss([
    'accessKey' => getenv('oss.ali.accessKey'),
    'accessSecret' => getenv('oss.ali.accessSecret'),
    'endpoint' => getenv('oss.ali.endpoint'),
    'bucket' => getenv('oss.ali.bucket')
]);

$config['components'] = $components;

return $config;
