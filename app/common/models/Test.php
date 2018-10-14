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
 * @property string $desc
 * @property string $cover
 * @property string $author
 * @property string $created_at
 * @property string $updated_at
 * @property Question[] $questions
 *
 * @package app\common\models
 */
class Test extends TinModel
{
    public $table = 'ou_test';
    
    public $fillable = [
        'title',
        'desc',
        'author',
        'cover'
    ];

    /**
     * @param array $params
     * @return mixed
     */
    public function search($params = [])
    {
        $query = Test::query();

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

    public function getQuestions()
    {
        return Question::query()->where(['test_id' => $this->id])->getModels();
    }
}