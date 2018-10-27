<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2018/10/24
 * Time: 23:23
 */
namespace console\actions;

use Tin\ConsoleActionInterface;
use Tin\Tin;

class test implements ConsoleActionInterface
{
    public function run($args)
    {
        dump($args, get_class(Tin::$app));
    }
}