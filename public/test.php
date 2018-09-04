<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/9/4
 * Time: 20:21
 */

require_once __DIR__ .  '/../vendor/autoload.php';
require_once __DIR__ . '/../app/boot.php';

$handle = [
    function($object){
        echo "this is abc start \n";
        yield;
        echo "this is abc end \n";
    },
    function($object){
        echo "this is qwe start \n";
        yield;
        echo "this is qwe end \n";
    },
];

(new \Tin\Middleware\Middleware())
    ->send(new \stdClass())
    ->through($handle)
    ->then(function($object){
        echo 'middle' . "\n";
    });

