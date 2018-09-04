<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/8/17
 * Time: 14:19
 */
namespace Tin\Middleware;

use Generator;

class Middleware
{
    /**
     * 默认加载的中间件
     *
     * @var array
     */
    protected $handlers = [];

    /**
     * 执行时传递给每个中间件的参数
     *
     * @var array|callable
     */
    protected $arguments;

    /**
     * 设置在中间件中传输的参数
     *
     * @param $arguments
     * @return self $this
     */
    public function send(...$arguments)
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * 设置经过的中间件
     *
     * @param $handle
     * @return $this
     */
    public function through($handle)
    {
        $this->handlers = is_array($handle) ? $handle : func_get_args();

        return $this;
    }

    /**
     * 运行中间件到达
     *
     * @param \Closure $destination
     * @return null|mixed
     */
    public function then(\Closure $destination)
    {
        $stack = [];
        $arguments = $this->arguments;
        foreach ($this->handlers as $handler) {
            $generator = call_user_func_array($handler, $arguments);

            if ($generator instanceof Generator) {
                $stack[] = $generator;

                $yieldValue = $generator->current();
                if ($yieldValue === false) {
                    break;
                }elseif($yieldValue instanceof Arguments){
                    //替换传递参数
                    $arguments = $yieldValue->toArray();
                }
            }
        }

        $result = $destination(...$arguments);
        $isSend = ($result !== null);
        $getReturnValue = version_compare(PHP_VERSION, '7.0.0', '>=');
        //重入函数栈
        while ($generator = array_pop($stack)) {
            /* @var $generator Generator */
            if ($isSend) {
                $generator->send($result);
            }else{
                $generator->next();
            }

            if ($getReturnValue) {
                $result = $generator->getReturn();
                $isSend = ($result !== null);
            }else{
                $isSend = false;
            }
        }

        return $result;
    }
}