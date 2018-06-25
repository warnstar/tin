<?php
/**
 * This file is part of Tin.
 */
namespace app\controllers;

use Tin\Base\Application;
use Tin\Base\Controller;

class IndexController extends Controller
{
    public function index($args = null)
    {
        $res = $this->request->getUri()->getPath();
        $data = $this->request->getParsedBody();

        return ['aaa' => $args, 'ccc' => 111];
    }

    public function create()
    {
        return ['aaa' => 123, 'ccc' => 111];
    }

    public function reload()
    {
        dump('重载服务器');
        return Application::swServer()->reload();
    }
}
