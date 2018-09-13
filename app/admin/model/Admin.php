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

    public $password_hash;

    /**
     * @param $username
     * @return Admin
     */
    public static function getOneByUserName($username)
    {
        $one = R::getRow( 'SELECT * FROM admin WHERE username = ? LIMIT 1',
            [ $username ]
        );

        $admin = new Admin();
        $admin->password_hash = $one['password_hash'];

        return $admin;
    }

    public function loginByPassword($password)
    {
        return $this->password_hash == $this->generatePasswordHash($password);
    }

    public function generatePasswordHash($password)
    {
        return md5(base64_encode($password));
    }
}