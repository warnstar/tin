<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/9/4
 * Time: 20:10
 */

function middleware($handlers,$arguments = []){
    //函数栈
    $stack = [];
    $result = null;

    foreach ($handlers as $handler) {
        // 每次循环之前重置，只能保存最后一个处理程序的返回值
        $result = null;
        $generator = call_user_func_array($handler, $arguments);

        if ($generator instanceof \Generator) {
            //将协程函数入栈,为重入做准备
            $stack[] = $generator;

            //获取协程返回参数
            $yieldValue = $generator->current();

            //检查是否重入函数栈
            if ($yieldValue === false) {
                break;
            }
        } elseif ($generator !== null) {
            //重入协程参数
            $result = $generator;
        }
    }

    $return = ($result !== null);
    //将协程函数出栈
    while ($generator = array_pop($stack)) {
        if ($return) {
            $generator->send($result);
        } else {
            $generator->next();
        }
    }
}



$abc = function(){
    echo "this is abc start \n";
    yield;
    echo "this is abc end \n";
};

$qwe = function (){
    echo "this is qwe start \n";
    $a = yield;
    echo $a."\n";
    echo "this is qwe end \n";
};
$one = function (){
    return 1;
};

middleware([$abc,$qwe,$one]);
