<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2018/6/24
 * Time: 20:04
 */
namespace Tin\Interfaces;

use Tin\Http\Request;

abstract class ControllerAbstract
{
    /**
     * @var Request $request
     */
    public $request;

    abstract protected function beforeAction();

    abstract protected function afterAction();

    /**
     * @param string $action
     * @return mixed
     */
    abstract protected function runAction($action);
}
