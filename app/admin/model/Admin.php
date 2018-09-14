<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/9/12
 * Time: 21:05
 */
namespace app\admin\model;

use app\common\base\TinModel;

class Admin extends TinModel
{
    public $table = 'admin';

    protected $fillable = ['username','password_hash', 'id', 'access_token'];

    protected $attributes = [
        'username','password_hash', 'id', 'access_token'
    ];
    /**
     * @param $username
     * @return self
     */
    public static function getOneByUserName($username)
    {
        $one = Admin::query()->where('username', '=', $username)->first();
        return $one;
    }

    /**
     * @param $password
     * @return mixed|null
     */
    public function loginByPassword($password)
    {
        if ($this->getAttribute('password_hash') != $this->generatePasswordHash($password)) {
            $this->addError('password', '密码不正确');
            return null;
        }

        $this->setAttribute('access_token', rand_str(48));

        if ($this->save()) {
            return $this->getAttribute('access_token');
        } else {
            $this->addError('admin', '无法保存用户');
            return null;
        }
    }

    public function generatePasswordHash($password)
    {
        return md5(base64_encode($password));
    }
}