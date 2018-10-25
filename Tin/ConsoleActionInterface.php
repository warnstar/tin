<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2018/10/24
 * Time: 23:19
 */
namespace Tin;

interface ConsoleActionInterface
{
    /**
     * @param $args array
     * @return mixed
     */
    public function run($args);
}