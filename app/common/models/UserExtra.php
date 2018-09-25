<?php
/**
 * This file is part of Tin.
 */
namespace app\admin\model;

use app\common\base\TinModel;


/**
 * Class User
 *
 * @property int $id;
 * @property int $user_id;
 * @property string $type;
 * @property string $code;
 * @property string $created_at
 * @property string $updated_at
 *
 * @package app\admin\model
 */
class User extends TinModel
{
    public $table = 'ou_user';

    protected $fillable = [
        'id', 'user_id', 'type', 'code', 'created_at', 'updated_at'
    ];

    public static function getOneByOpenId($open_id)
    {
        
    }
}
