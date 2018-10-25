<?php
/**
 * This file is part of Tin.
 */
namespace Tin\Http;

/**
 * Provides a PSR-7 implementation of a reusable raw request body
 */
class RequestBody
{
    public $rawData = '';

    public function __toString()
    {
        return $this->rawData;
    }

    /**
     * RequestBody constructor.
     * @param string $rawData
     */
    public function __construct($rawData = '')
    {
        $this->rawData = $rawData ? $rawData : '';
    }
}
