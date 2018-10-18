<?php
/**
 * This file is part of Tin.
 */
namespace app\admin\models;

use app\common\models\User;

/**
 * Class User
 *

 * @package app\admin\model
 */
class UserSearch extends User
{

    /**
     * @param array $params
     * @return mixed
     */
    public function search($params = [])
    {
        $query = self::query();

        $page = $query->paginate();


        if (isset($params['page'])) {
            $query->offset($page->perPage() * $params['page']);
        }

        $query->orderByDesc('id');

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
