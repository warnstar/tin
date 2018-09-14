<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/9/12
 * Time: 21:05
 */
namespace app\admin\model;

use Illuminate\Database\Eloquent\Model;
use Tin\Tin;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class Admin extends Model
{

    public $table = 'admin';

    public $password_hash;

    /**
     * @param $username
     * @return Admin
     */
    public static function getOneByUserName($username)
    {
        $one = Admin::query()->where('username', '=', $username);

        return $one;
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