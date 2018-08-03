<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/7/30
 * Time: 20:05
 */

namespace Tin;

use Tin\Http\Request;

class Route
{
    protected $pattern = '';

    protected $method = '';

    protected $group = '';

    protected $callable;

    protected $identifier;

    /**
     * Create new route
     *
     * @param string            $method The route HTTP methods
     * @param string            $pattern The route pattern
     * @param callable          $callable The route callable
     */
    public function __construct($method, $pattern, $callable, $group = '', $identifier = 0)
    {
        $this->method  = $method;
        $this->pattern  = $pattern;
        $this->callable = $callable;
        $this->group   = $group;
        $this->identifier = $identifier;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    public function getRoute()
    {
        return $this->group . $this->pattern;
    }

    public function getGroup()
    {
        return $this->group;
    }

    public function getCallable()
    {
        return $this->callable;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function run($vars = null, Request &$request)
    {
        if (is_callable($this->callable)) {
            $data = $this->getCallable()($vars);
        } else {
            list($class, $method) = explode('@', $this->callable);

            if (!class_exists($class)) {
                throw new \Exception(sprintf("Class %s Is Not Found!", $class));
            }

            /**
             * @var $object Controller
             */
            $object = new $class;

            $object->request = $request;
            $data = $object->runAction($method, $vars);
        }

        return $data;
    }
}