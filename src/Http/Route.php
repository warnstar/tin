<?php
/**
 * This file is part of Tin.
 */
namespace Tin\Http;

class Route
{
    public $id;

    public $method = '';

    public $route = '';

    /**
     * @var callable $callable
     */
    public $callable;

    public $middleware;
}
