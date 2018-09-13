<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/9/12
 * Time: 21:05
 */
namespace app\admin\model;

use atk4\data\Model;
use Tin\Tin;

class Admin extends Model
{

    public $table = 'user';

    public function init()
    {
        parent::init();

        $this->addFields([
            'id',
            'username',
            'password_hash',
            'created_at',
            'updated_at'
        ]);
    }

    public $password_hash;

    /**
     * @param $username
     * @return Admin
     */
    public static function getOneByUserName($username)
    {
        $one = new Admin(Tin::$app->db);
        $one = $one->loadBy('username', $username);

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