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


    /**
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function search($params = [])
    {

        $query = Test::query();

        $res = $query->get();

        return $res;
    }
}