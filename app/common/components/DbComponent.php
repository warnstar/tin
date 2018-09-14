<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/9/14
 * Time: 10:25
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
            'prefix'    => '',
        ]);

        $capsule->setEventDispatcher(new Dispatcher(new Container));

        $capsule->bootEloquent();

        return $capsule;
    }

}