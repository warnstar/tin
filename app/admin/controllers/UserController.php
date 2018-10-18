<?php
/**
 * This file is part of Tin.
 */
namespace app\admin\controllers;

use app\admin\models\UserSearch;
use app\common\helpers\ApiResponse;

use Tin\Controller;

class UserController extends Controller
{
    public function index()
    {
        $params = $this->request->getQueryParams();

        $res = (new UserSearch())->search($params);

        return ApiResponse::success($res);
    }
}
