<?php
/**
 * This file is part of Tin.
 */
namespace Tin\Interfaces;

use Tin\Http\Request;

abstract class ControllerAbstract
{
    /**
     * @var Request $request
     */
    public $request;

    abstract public function beforeAction();

    abstract public function afterAction();

    /**
     * @param string $action
     * @return mixed
     */
    abstract public function runAction($action);
}
