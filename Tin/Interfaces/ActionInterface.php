<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/7/27
 * Time: 10:59
 */
namespace Tin\Interfaces;

interface ActionInterface
{
    public function runAction($action, $vars = null);
}