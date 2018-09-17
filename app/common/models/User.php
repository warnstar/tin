<?php
/**
 * This file is part of Tin.
 */
namespace app\admin\model;

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
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 * @package app\admin\model
 */
class User extends TinModel
{
    public $table = 'ou_user';

    protected $attributes = [
        'id', 'nickname', 'wechat_id', 'union_id', 'user_mobile', 'city', 'province', 'country', 'sex', 'created_at', 'updated_at', 'deleted_at'
    ];

}