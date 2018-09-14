<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/9/14
 * Time: 10:24
 */




$components['capsule'] = \app\common\components\DbComponent::getInstance();
$components['router'] =  require(APP_PATH . '/router/router.php');
$components['server'] = \Tin\HttpServer::build();


$config['components'] = $components;
return $config;