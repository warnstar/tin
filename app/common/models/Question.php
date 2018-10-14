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
 * @property QuestionItem[] $items
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

    const TYPE_SELECT = 'select';
    const TYPE_UPLOAD_IMG = 'upload_img';

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


    /**
     * @return QuestionItem[]
     */
    public function getItems()
    {
        return QuestionItem::query()->where(['question_id' => $this->id])->getModels();
    }

    public function fill(array $attributes)
    {
        if (!empty($attributes['items']) && is_array($attributes['items'])) {
            $items = [];
            foreach ($attributes['items'] as $item) {
                if (!empty($item['id'])) {
                    $itemObj = QuestionItem::getOneById($item['id']);
                } else {
                    $itemObj = new QuestionItem(['question_id' => $this->id]);
                }

                $itemObj->fill($item);

                $items[] = $itemObj;
            }

            $this->setAttribute('items', $items);
        }

        return parent::fill($attributes);
    }

    public function save(array $options = [])
    {
        if ($this->items) {
            $itemIds = [];
            foreach ($this->items as $item) {
                if ($item->save()) {
                    $itemIds[] = $item->id;
                }
            }

            QuestionItem::query()->where('id', 'not in', $itemIds)->delete();
        }

        unset($this->items);

        return parent::save($options);
    }
}