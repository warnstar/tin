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
 * @property int $question_id
 * @property string $name
 * @property string $option
 * @property string $created_at
 * @property string $updated_at
 *
 * @package app\common\models
 */
class QuestionItem extends TinModel
{
    public $table = 'ou_question_item';
    
    public $fillable = [
        'question_id',
        'name',
        'option',
    ];

    /**
     * @param array $params
     * @return mixed
     */
    public function search($params = [])
    {
        $query = QuestionItem::query();

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