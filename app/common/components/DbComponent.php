<?php
/**
 * This file is part of Tin.
 */
namespace app\common\components;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class DbComponent
{
    public static function getInstance()
    {
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => getenv('db.host'),
            'database'  => getenv('db.database'),
            'username'  => getenv('db.username'),
            'password'  => getenv('db.password'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'loggingQueries' => false,
            'prefix'    => '',
        ]);

        $capsule->setEventDispatcher(new Dispatcher(new Container));

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return $capsule;
    }
}
