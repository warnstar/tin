<?php
/**
 * This file is part of Tin.
 */

function autoload($className)
{
    $classFile = str_replace('\\', '/', $className) . '.php';
    if ($classFile === false || !is_file($classFile)) {
        return;
    }

    include $classFile;
}
spl_autoload_register('autoload', true, true);

define('APP_ROOT', __DIR__ . '/../');
define('APP_PATH', APP_ROOT . '/app');
