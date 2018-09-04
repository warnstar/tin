<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/8/17
 * Time: 14:20
 */

$handle = [
    function($object){
        $object->hello = 'hello ';
    },
    function($object){
        $object->hello .= 'world';
    },
];

(new \Tin\Middleware\Middleware())
    ->send(new \stdClass())
    ->through($handle)
    ->then(function($object){
        echo $object->hello;
    });

/*
 * output
 *
 * hello world
 */