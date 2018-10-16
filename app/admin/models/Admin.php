<?php
/**
 * This file is part of Tin.
 */
namespace app\admin\models;

use app\common\base\TinModel;

/**
 * Class Admin
 *
 * @property string $id;
 * @property string $username
 * @property string $password_hash
 * @property string $access_token
 *
 * @package app\admin\model
 */
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
        if ($this->password_hash != $this->generatePasswordHash($password)) {
            $this->addError('password', '密码不正确');
            return null;
        }

        $this->access_token = rand_str(48);

        if ($this->save()) {
            return $this->access_token;
        } else {
            $this->addError('admin', '无法保存用户');
            return null;
        }
    }

    public static function getOneByToken($token)
    {
        $one = Admin::query()->where('access_token', '=', $token)->first();
        return $one;
    }

    public function generatePasswordHash($password)
    {
        return md5(base64_encode($password));
    }
}
