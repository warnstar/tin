<?php
/**
 * This file is part of Tin.
 */
namespace Tin\Interfaces;

interface ActionInterface
{
    public function runAction($action, $vars = null);
}
