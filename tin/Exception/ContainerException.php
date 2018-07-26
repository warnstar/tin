<?php
/**
 * This file is part of Tin.
 */
namespace Tin\Exception;

use InvalidArgumentException;
use Interop\Container\Exception\ContainerException as InteropContainerException;

/**
 * Container Exception
 */
class ContainerException extends InvalidArgumentException implements InteropContainerException
{
}
