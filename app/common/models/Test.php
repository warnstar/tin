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
 * Class Test
 * @property int $id
 * @property string $title
 * @property string desc
 * @property string $cover
 * @property string $created_at
 * @property string $updated_at
 *
 * @package app\common\models
 */
class Test extends TinModel
{
    public $table = 'ou_test';

    protected $attributes = [
        'id', 'title', 'desc', 'cover', 'created_at', 'updated_at'
    ];

    public function search()
    {

    }
}