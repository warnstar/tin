<?php
/**
 * This file is part of Tin.
 */
namespace app\common\models;

use app\common\base\TinModel;


/**
 * Class UserExtra
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
class UserExtra extends TinModel
{
    public $table = 'ou_user_extra';

    protected $fillable = [
        'id', 'user_id', 'type', 'code', 'created_at', 'updated_at'
    ];

    const TYPE_WECHAT = 'wechat';

    public static function getOneByOpenId($open_id)
    {
        
    }

    public static function createByUserAndOpenId($open_id, $user_id)
    {
        $one = new UserExtra();
        $one->user_id = $user_id;
        $one->code = $open_id;
        $one->type = self::TYPE_WECHAT;

        return $one->save();
    }
}
