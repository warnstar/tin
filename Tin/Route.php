<?php
/**
 * This file is part of Tin.
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
     * @var $object Controller
     */
    protected $runObject;

    protected $runMethod;

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
        $this->pattern  = substr($pattern, 0, 1) == '/' ? $pattern : '/' . $pattern;
        $this->callable = $callable;
        $this->group   = $group;
        $this->identifier = $identifier;

        $this->buildRunObject();
    }

    protected function buildRunObject()
    {
        list($class, $classMethod) = explode('@', $this->callable);

        if (!class_exists($class)) {
            throw new \Exception(sprintf('Class %s Is Not Found !', $class));
        }

        /**
         * @var $object Controller
         */
        $object = new $class;

        if (!method_exists($object, $classMethod)) {
            throw new \Exception(sprintf('Method %s Is Not In Class %s !', $classMethod, $class));
        }

        $this->runObject = $object;
        $this->runMethod = $classMethod;
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
        $object = clone $this->runObject;

        $object->request = &$request;
        $data = $object->runAction($this->runMethod, $vars);

        return $data;
    }
}
