<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/9/12
 * Time: 9:59
 */
namespace app\common\helpers;

class BaseResponse
{
    protected static $successType = "OK";

    protected static $errorTypes = [
        'OK'                =>  200,
        'DENY'              =>  403,
        'UN_AUTH'          =>  401,
        'PARAM'             =>  400,
        'EXIST'             =>  409,
        'NOT_FOUND'         =>  404,
        'BUSY'              =>  503,
        'SERVER'            =>  500,
    ];
    protected static $defaultMessage = [
        'OK'                =>  '',
        'UN_AUTH'          =>  '未受权',
        'DENY'              =>  "禁止访问",
        'PARAM'             =>  "参数错误",
        'EXIST'             =>  "对象已存在",
        'NOT_FOUND'         =>  "对象不存在",
        'BUSY'              =>  "系统繁忙",
        'SERVER'            =>  "操作失败",
    ];



    protected static function buildResponse($type = '', $message = '', $info = [], $code = '')
    {
        if (in_array($type, array_keys(self::$errorTypes), null)) {
            $errCode = self::$errorTypes[$type];
        } else {
            $errCode = self::$errorTypes['SERVER'];
        }
        if (!$message) {
            $message = self::$defaultMessage[$type];
        }

        $data = [
            'status'   =>  $errCode,
            'code'      => $code,
            'message'    =>  $message,
            'data'      =>  $info,
        ];
        return $data;
    }
}
