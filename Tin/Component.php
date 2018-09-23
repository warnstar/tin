<?php
/**
 * Created by PhpStorm.
 * User: huangweichang
 * Date: 2018/9/23
 * Time: 下午3:24
 */
namespace Tin;

class Component
{
    public function __construct($config = [])
    {
        if ($config && is_array($config)) foreach ($config as $k => $v) {
            if (isset($this->$k)) {
                 $this->$k = $v;
            }
        }
    }
}