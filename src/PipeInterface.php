<?php

declare(strict_types=1);

namespace Dhii\Pipe;

use Dhii\Pipe\Exception\DispatchExceptionInterface;
use Dhii\Pipe\Exception\PipeExceptionInterface;

/**
 * @template Input
 * @template Output
 */
interface PipeInterface
{
    /**
     * Dispatches this middleware pipe.
     *
     * This will start a sequence of middlewares, which process the input.
     *
     * @param mixed $input The input to process by the pipe.
     * @psalm-param \Input $input
     * @return mixed The result of processing.
     * @psalm-return \Output
     * @throws DispatchExceptionInterface If one of the middlewares caused an error.
     * @throws PipeExceptionInterface If problem dispatching.
     */
    public function dispatch($input);
}
