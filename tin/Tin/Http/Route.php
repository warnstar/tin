<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18-6-26
 * Time: 下午7:03
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