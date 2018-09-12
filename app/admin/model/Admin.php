<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/9/12
 * Time: 21:05
 */
namespace app\admin\model;

use RedBeanPHP\R;

class Admin {
    public static function getOneByUserName($username)
    {
        $one = R::getRow( 'SELECT * FROM admin WHERE username = ? LIMIT 1',
            [ $username ]
        );

        return $one;
    }
}