<?php
/**
 * This file is part of Tin.
 */
namespace app\admin\controllers;

use Tin\Controller;

class IndexController extends Controller
{
    public function index($args = null)
    {
        $this->request->getHeaders();
        $this->request->getHeader('key');
        $res = $this->request->getUri()->getPath();
        $data = $this->request->getParsedBody();
        # query
        $this->request->getQueryParams();
        $this->request->getQueryParam('key');

        # form or json
        $this->request->getParsedBodyParam('key', 'default');
        $this->request->getParsedBody();

        return ['aaa' => $args, 'ccc' => 111, 'd' => 12];
    }

    public function mid()
    {
        return $this->request;
    }

    public function create()
    {
        $params = $this->request->getParsedBody();
        return $params;
    }
}
