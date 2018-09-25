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
     * @var Tin|BaseTin|AppTin the application instance
     */
    public static $app;

    /**
     * @var $test string
     */
    public static $test;
}


abstract class BaseTin extends Tin\Tin
{
    /**
     * @var $router \Tin\Router
     */
    public $router;

    /**
     * @var $server \Tin\HttpServer
     */
    public $server;
}


abstract class AppTin extends Tin\Tin
{
    /**
     * @var $wechat \app\common\components\Wechat
     */
    public $wechat;

    /**
     * @var $storage \app\common\components\storage\ObjectStorage
     */
    public $storage;
}