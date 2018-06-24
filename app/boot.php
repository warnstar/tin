<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2018/6/24
 * Time: 19:02
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



\Tin\Base\Router::get('/users', \app\controllers\IndexController::class . "@index");
\Tin\Base\Router::get('/index/{id:\d+}', \app\controllers\IndexController::class . "@index");
\Tin\Base\Router::post('/index', \app\controllers\IndexController::class . "@create");