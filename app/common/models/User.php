<?php
/**
 * This file is part of Tin.
 */
namespace app\common\models;

use app\common\base\TinModel;


/**
 * Class User
 *
 * @property integer $id;
 * @property string $nickname
 * @property string $avatar
 * @property string $union_id
 * @property string $user_mobile
 * @property string $city
 * @property string $province
 * @property string $country
 * @property string $sex '1=男；0=女'
 * @property integer $is_teacher;
 * @property string $access_token
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $open_id

 * @package app\admin\model
 */
class User extends TinModel
{
    public $table = 'ou_user';

    protected $fillable = [
        'nickname', 'avatar', 'union_id', 'user_mobile', 'city', 'province', 'country', 'sex', 'access_token', 'is_teacher', 'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * @param $open_id
     * @return self
     */
    public static function getOneByOpenId($open_id)
    {
        $one = User::query()
            ->select("ou_user.*")
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

    public static function getOneByToken($token)
    {
        $one = self::query()->where('access_token', '=', $token)->first();
        return $one;
    }

    /**
     * @return mixed|string
     */
    public function getOpen_id()
    {
        $extra = UserExtra::query()->where(['user_id' => $this->id, 'type' => UserExtra::TYPE_WECHAT])
            ->first();

        return $extra ? $extra->code : '';
    }
}
