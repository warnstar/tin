<?php
/**
 * This file is part of Tin.
 */

$components['capsule'] = \app\common\components\DbComponent::getInstance();
$components['router'] =  require(APP_PATH . '/router/router.php');
$components['server'] = \Tin\HttpServer::build();


$config['components'] = $components;
return $config;
