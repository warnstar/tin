<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/9/17
 * Time: 20:25
 */
namespace app\common\models;

use app\common\base\TinModel;

/**
 * Class DesireUser
 * @property int $id
 * @property int $user_id
 * @property int $test_id
 * @property string $selects
 * @property string $created_at
 * @property string $updated_at
 *
 * @package app\common\models
 */
class DesireUser extends TinModel
{
    public $table = 'ou_desire_user';
    
    public $fillable = [
        'user_id',
        'test_id',
        'selects'
    ];

    /**
     * @param $test_id
     * @param $user_id
     * @return self
     */
    public static function getLastOneByTestAndUser($test_id, $user_id)
    {
        $one = self::query()
            ->orderBy("id", "DESC")
            ->where(['test_id' => $test_id, 'user_id' => $user_id])
            ->first();

        return $one;
    }
}