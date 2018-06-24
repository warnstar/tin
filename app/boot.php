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



\Tin\Base\Router::get('/users', \app\controllers\IndexController::class . '@index');
\Tin\Base\Router::get('/index/{id:\d+}', \app\controllers\IndexController::class . '@index');
\Tin\Base\Router::post('/index', \app\controllers\IndexController::class . '@create');
