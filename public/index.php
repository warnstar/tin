<?php
/**
 * This file is part of Tin.
 */
require_once __DIR__ .  '/../vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv(dirname(__DIR__));
$dotenv->load();

// Tin
require_once __DIR__ . '/../tin/Tin.php';

require_once __DIR__ . '/../app/boot.php';



(new \Tin\Base\Application())->run();
