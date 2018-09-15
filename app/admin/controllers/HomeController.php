<?php
/**
 * This file is part of Tin.
 */
namespace app\admin\controllers;

use Tin\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return $this->request->user;
    }
}
