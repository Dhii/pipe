<?php

declare(strict_types=1);

namespace Dhii\Pipe\Exception;

use Dhii\Pipe\PipeAwareInterface;
use Throwable;

/**
 * A problem with a pipe.
 */
interface PipeExceptionInterface extends
    Throwable,
    PipeAwareInterface
{

}
