<?php

declare(strict_types=1);

namespace Dhii\Pipe\Exception;

use Dhii\Pipe\MiddlewareAwareInterface;
use Dhii\Pipe\PipeAwareInterface;
use Throwable;

/**
 * A problem with a middleware.
 */
interface MiddlewareExceptionInterface extends
    Throwable,
    MiddlewareAwareInterface
{

}
