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
        'id', 'user_id', 'open_id', 'form_id', 'created_at', 'updated_at'
    ];
}
