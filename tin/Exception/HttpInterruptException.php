<?php
/**
 * This file is part of Tin.
 */

namespace Tin\Exception;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HttpInterruptException extends TinException
{
    public function __construct(ServerRequestInterface $request, ResponseInterface $response, $message = 'HttpInterrupt')
    {
        $this->message = $message;
        parent::__construct($request, $response);
    }
}
