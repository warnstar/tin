<?php
/**
 * This file is part of Tin.
 */
require_once __DIR__ .  '/../vendor/autoload.php';

require_once __DIR__ . '/../app/boot.php';
require_once __DIR__ . '/../app/Tin.php';

$config = require(APP_PATH . "/common/config/base.php");

(new \Tin($config['components']))->run();
