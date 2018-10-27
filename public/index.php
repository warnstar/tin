<?php
/**
 * This file is part of Tin.
 */
require_once __DIR__ .  '/../vendor/autoload.php';

require_once __DIR__ . '/../app/boot.php';

$config = array_merge(
    require(APP_PATH . "/common/config/base.php"),
    require(APP_PATH . "/common/config/http.php")
);

(new \Tin\HttpTin($config['components']))->run();
