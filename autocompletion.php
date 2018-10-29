<?php
/**
 * Yii bootstrap file.
 * Used for enhanced IDE code autocompletion.
 * Note: To avoid "Multiple Implementations" PHPStorm warning and make autocomplete faster
 * exclude or "Mark as Plain Text" vendor/yiisoft/yii2/Yii.php file
 */
class Tin extends Tin\Tin
{
    /**
     * @var $app Tin|HttpTin|AppTin|ConsoleTin the application instance
     */
    public static $app;
}


abstract class HttpTin extends Tin\Tin
{
    /**
     * @var $router \Tin\Router
     */
    public $router;

    /**
     * @var $server \Tin\HttpServer
     */
    public $server;

    /**
     * @var $capsule Illuminate\Database\Capsule\Manager
     */
    public $capsule;
}


abstract class AppTin extends Tin\Tin
{
    /**
     * @var $wechat \app\common\components\Wechat
     */
    public $wechat;


}

abstract class ConsoleTin extends Tin\Tin
{
    /**
     * @var $console \Tin\Console
     */
    public $console;


}