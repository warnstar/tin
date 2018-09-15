<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/9/15
 * Time: 14:31
 */
namespace app\common\base;

trait ErrorTrait
{
    /**
     * @var $error string[]
     */
    private $error;

    /**
     * @param string $key
     * @param string $message
     */
    public function addError($key, $message)
    {
        $this->error[$key] = $message;
    }

    /**
     * @param array $errors
     */
    public function addErrors(array $errors)
    {
        foreach ($errors as $k => $v) {
            $this->addError($k, $v);
        }
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->error;
    }

    /**
     * @return string
     */
    public function getErrorFirstString()
    {
        if ($this->error) {
            foreach ($this->error as $k => $v) {
                if ($v) {
                    return $v;
                }
            }
        }

        return '';
    }
}