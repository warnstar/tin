<?php
/**
 * This file is part of Tin.
 */
namespace app\admin\controllers;

use app\admin\model\Admin;
use app\common\helpers\ApiResponse;
use Tin\Controller;

class AdminController extends Controller
{
    public function detail()
    {
        $admin = $this->request->user->id;

        if ($admin) {
            return ApiResponse::success($admin);
        } else {
            return ApiResponse::error('PARAM', '用户不存在');
        }
    }
}
