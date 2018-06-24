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

    abstract protected function beforeAction();

    abstract protected function afterAction();

    /**
     * @param string $action
     * @return mixed
     */
    abstract protected function runAction($action);
}
