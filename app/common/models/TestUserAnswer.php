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
 * Class QuestionItem
 * @property int $test_id
 * @property int $user_id
 * @property string $answers
 * @property string $created_at
 * @property string $updated_at
 *
 * @package app\common\models
 */
class TestUserAnswer extends TinModel
{
    public $table = 'ou_test_user_answer';
    
    public $fillable = [
        'test_id',
        'user_id',
        'answers'
    ];

    /**
     * @param $user_id
     * @return self
     */
    public static function getLastOneByUser($user_id)
    {
        return self::query()
            ->where([
                'user_id' => $user_id
            ])
            ->orderBy("id", "DESC")
            ->first();
    }
}