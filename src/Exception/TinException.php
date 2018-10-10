<?php
/**
 * This file is part of Tin.
 */
namespace Tin\Exception;

use Exception;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Stop Exception
 *
 * This Exception is thrown when the Slim application needs to abort
 * processing and return control flow to the outer PHP script.
 */
class TinException extends Exception
{
    /**
     * A request object
     *
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * A response object to send to the HTTP client
     *
     * @var ResponseInterface
     */
    protected $response;

    /**
     * Create new exception
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     */
    public function __construct(ServerRequestInterface $request, ResponseInterface $response)
    {
        parent::__construct();
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Get request
     *
     * @return ServerRequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get response
     *
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
