<?php

abstract class PimpleContainer extends  Pimple\Container implements \Composer\Semver\Constraint\ConstraintInterface
{

    /**
     * @var $router \Tin\Base\Router
     */
    public $router;
}
