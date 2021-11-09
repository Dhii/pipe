<?php

declare(strict_types=1);

namespace Dhii\Pipe;

use Dhii\Pipe\Exception\DispatchExceptionInterface;
use Dhii\Pipe\Exception\MiddlewareExceptionInterface;
use Dhii\Pipe\Exception\PipeExceptionInterface;

/**
 * @template I
 * @template O
 */
interface PipeInterface
{
    /**
     * Dispatches this middleware pipe.
     *
     * This will start a sequence of middlewares, which process the input.
     *
     * @param mixed $input The input to process by the pipe.
     * @psalm-param I $input
     * @return mixed The result of processing.
     * @psalm-return O
     * @throws DispatchExceptionInterface If one of the middlewares caused an error.
     * @throws PipeExceptionInterface If problem dispatching.
     */
    public function dispatch($input);
}
