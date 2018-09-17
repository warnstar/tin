<?php
/**
 * This file is part of Tin.
 */
namespace app\admin\controllers;

use app\admin\model\Admin;
use app\common\helpers\ApiResponse;
use Tin\Controller;

class TestController extends Controller
{
    public function index()
    {

        return ApiResponse::success([]);
    }

}
