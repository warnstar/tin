<?php
/**
 * This file is part of Tin.
 */
namespace Tin\Middleware;

/**
 * ArrayAccess 是PHP提供的一个预定义接口,用来提供数组式的访问
 * 可以参考http://php.net/manual/zh/class.arrayaccess.php
 */
use ArrayAccess;

/**
 * 这个类是用来提供中间件参数的
 * 比如中间件B需要一个由中间件A专门提供的参数,
 * 那么中间件A可以通过 “yield new Arguments('foo','bar','baz')”将参数传给中间件B
 */
class Arguments implements ArrayAccess
{
    private $arguments;

    /**
     * 注册传递的参数
     *
     * Arguments constructor.
     * @param array $param
     */
    public function __construct($param)
    {
        $this->arguments = is_array($param) ? $param : func_get_args();
    }

    /**
     * 获取参数
     *
     * @return array
     */
    public function toArray()
    {
        return $this->arguments;
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->arguments);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->arguments[$offset] : null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->arguments[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->arguments[$offset]);
    }
}
