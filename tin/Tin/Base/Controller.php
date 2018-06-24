<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2018/6/24
 * Time: 19:56
 */
namespace Tin\Base;

use Tin\Http\Response;
use Tin\Interfaces\ControllerAbstract;

class Controller extends ControllerAbstract
{
    public $ContentType = 'application/json';

    public function runAction($action, $vars = null)
    {
        $this->beforeAction();

        $data = $this->$action($vars);

        $this->afterAction();

        return $this->formatResponse($data);
    }

    protected function formatResponse($data)
    {
        switch ($this->ContentType) {
            case Response::CONTENT_TYPE_JSON:
                $this->request->response->withHeader('Content-Type', 'application/json;charset=utf-8');
                $data = json_encode($data);
                break;
            case Response::CONTENT_TYPE_TEXT:
                $this->request->response->withHeader('Content-Type', 'text/html');
                break;
            default:
                $this->request->response->withHeader('Content-Type', 'text/html');
        }

        return $data;
    }

    protected function beforeAction()
    {

    }

    protected function afterAction()
    {

    }
}