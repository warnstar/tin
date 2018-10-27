<?php
/**
 * This file is part of Tin.
 */
namespace app\common\models;

use app\common\base\TinModel;

/**
 * Class UserWechatFormId
 *
 * @property int $id;
 * @property int $user_id;
 * @property int $is_used;
 * @property string $open_id;
 * @property string form_id;
 * @property string $created_at
 * @property string $updated_at
 *
 * @package app\admin\model
 */
class UserWechatFormId extends TinModel
{
    public $table = 'ou_user_wechat_form_id';

    protected $fillable = [
        'id', 'user_id', 'open_id','is_used', 'form_id', 'created_at', 'updated_at'
    ];

    /**
     * @param int $user_id
     * @return self
     */
    public static function getOneByUserId(int $user_id)
    {
        $query = self::query()
            ->where('user_id', '=', $user_id)
            ->where(['is_used' => 0])
            ->whereRaw("created_at > date_add( NOW(), interval  -7 day)");

        return $query->first();
    }

    public function used()
    {
        $this->is_used = 1;

        return $this->save();
    }
}
