<?php
/**
 * This file is part of Tin.
 */

namespace Tin;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;

class BaseTin
{
    /**
     * @var $app self
     */
    public static $app;

    /**
     * Container
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * Create new application
     *
     * @param ContainerInterface|array $container Either a ContainerInterface or an associative array of app settings
     * @throws InvalidArgumentException when no container is provided that implements ContainerInterface
     */
    public function __construct($container = [])
    {
        if (self::$app) {
            throw new \Exception('只能创建运行一个实例');
        }

        if (is_array($container)) {
            $container = new Container($container);
        }
        if (!$container instanceof ContainerInterface) {
            throw new InvalidArgumentException('Expected a ContainerInterface');
        }
        $this->container = $container;

        self::$app = $this;
    }

    public function run()
    {

    }
    /**
     * Calling a non-existant method on App checks to see if there's an item
     * in the container that is callable and if so, calls it.
     *
     * @param  string $method
     * @param  array $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        if ($this->container->has($method)) {
            $obj = $this->container->get($method);
            if (is_callable($obj)) {
                return call_user_func_array($obj, $args);
            }
        }

        throw new \BadMethodCallException("Method $method is not a valid method");
    }

    /**
     * 外部访问容器内对象
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->container->get($name);
    }

    public static function autoload($className)
    {
        if (strpos($className, '\\') !== false) {
            $classFile = str_replace('\\', '/', $className) . '.php';
            if ($classFile === false || !is_file($classFile)) {
                return;
            }
        } else {
            return;
        }

        include $classFile;

        if (!class_exists($className, false) && !interface_exists($className, false) && !trait_exists($className, false)) {
            throw new \Exception("Unable to find '$className' in file: $classFile. Namespace missing?");
        }
    }
}
