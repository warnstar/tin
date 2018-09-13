<?php
/**
 * This file is part of Tin.
 */
require_once __DIR__ .  '/../vendor/autoload.php';

require_once __DIR__ . '/../app/boot.php';

$components['router'] =  require(__DIR__ . '/../app/router/router.php');


$components['server'] = \Tin\HttpServer::build();
(new \Tin\Tin($components))->run();
