<?php
/**
 * This file is part of Tin.
 */

if (!function_exists('printConsole')) {
    function printConsole($var)
    {
        dump($var);
    }
}


if (!function_exists('rand_str')) {
    function rand_str($length = 32)
    {
        // 密码字符集，可任意添加你需要的字符
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        return $str;
    }
}
