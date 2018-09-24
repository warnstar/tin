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
 * @property int $test_id
 * @property string $title
 * @property string $desc
 * @property string $type
 * @property string $created_at
 * @property string $updated_at
 *
 * @package app\common\models
 */
class Question extends TinModel
{
    public $table = 'ou_question';
    
    public $fillable = [
        'test_id',
        'title',
        'desc',
        'type'
    ];

    /**
     * @param array $params
     * @return mixed
     */
    public function search($params = [])
    {
        $query = Question::query();

        $page = $query->paginate();


        if (isset($params['page'])) {
            $query->offset($page->perPage() * $params['page']);
        }

        $query->orderByDesc("id");

        $data = $query->get();

        $res['data'] = $data;
        $res['page'] = [
            'current_page' => $page->currentPage(),
            'per_page' => $page->perPage(),
            'total' => $page->total()
        ];

        return $res;
    }
}