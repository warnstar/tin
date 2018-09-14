<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/9/12
 * Time: 10:08
 */

namespace app\common\helpers;

class ApiResponse extends BaseResponse
{
    /**
     * 构造相应数据
     * @param array $data
     * @return mixed
     */
    protected static function returnData($data = [])
    {
        return $data;
    }


    /**
     * @param mixed $info
     * @return mixed
     */
    public static function success($info = [])
    {
        $data = self::buildResponse(self::$successType, '', $info);

        return self::returnData($data);
    }

    public static function error($type, $msg = '', $code = 0)
    {
        $data = self::buildResponse($type, $msg, null, $code);

        return self::returnData($data);
    }
}
