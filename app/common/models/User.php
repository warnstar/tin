<?php
/**
 * This file is part of Tin.
 */
namespace app\common\models;

use app\common\base\TinModel;


/**
 * Class User
 *
 * @property string $id;
 * @property string $nickname
 * @property string $headimg
 * @property string $wechat_id
 * @property string $union_id
 * @property string $user_mobile
 * @property string $city
 * @property string $province
 * @property string $country
 * @property string $sex '1=男；0=女'
 * @property string $access_token
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 * @package app\admin\model
 */
class User extends TinModel
{
    public $table = 'ou_user';

    protected $fillable = [
        'id', 'nickname', 'wechat_id', 'union_id', 'user_mobile', 'city', 'province', 'country', 'sex', 'access_token', 'created_at', 'updated_at', 'deleted_at'
    ];
    protected $attributes = [
        'id', 'nickname', 'wechat_id', 'union_id', 'user_mobile', 'city', 'province', 'country', 'sex', 'access_token', 'created_at', 'updated_at', 'deleted_at'
    ];

    public static function getOneByOpenId($open_id)
    {
        $one = User::query()
            ->leftjoin('ou_user_extra','ou_user_extra.user_id','=','ou_user.id')
            ->where(['ou_user_extra.code' => $open_id])
            ->first();

        return $one;
    }


    /**
     * @param $open_id
     * @return User | null
     */
    public static function createByOpenId($open_id)
    {
        $one = new User();
        if ($one->save()) {
            if (UserExtra::createByUserAndOpenId($open_id, $one->id)) {
                return $one;
            }
        }

    }


    public function generatePasswordHash($password)
    {
        return md5(base64_encode($password));
    }
}
