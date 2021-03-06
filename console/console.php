<?php
/**
 * This file is part of Tin.
 */
require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../app/boot.php';

$config['components']['capsule'] = \app\common\components\DbComponent::getInstance();

$config['components']['console'] = new \Tin\Console(require(APP_ROOT . "/console/routes.php"));

(new \Tin\ConsoleTin($config['components']))->run($argv);