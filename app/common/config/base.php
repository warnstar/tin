<?php
/**
 * This file is part of Tin.
 */

$components['capsule'] = \app\common\components\DbComponent::getInstance();

$components['storage'] = new \app\common\components\storage\instance\AliOss([
    'accessKey' => getenv('oss.ali.accessKey'),
    'accessSecret' => getenv('oss.ali.accessSecret'),
    'endpoint' => getenv('oss.ali.endpoint'),
    'bucket' => getenv('oss.ali.bucket')
]);

$config['components'] = $components;

return $config;
