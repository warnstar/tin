<?php
/**
 * This file is part of Tin.
 */
namespace Tin\Base;

class Exception extends \Exception
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'Exception';
    }
}
