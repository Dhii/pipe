<?php

declare(strict_types=1);

namespace Dhii\Pipe;

use RuntimeException;

/**
 * Something that can create a middleware pipe from middlewares.
 */
interface MiddlewarePipeFactoryInterface
{
    /**
     * Creates a pipe from given middleware.
     *
     * @param iterable<MiddlewareInterface> $middleware The list of middleware that will process the input
     *                                                  once the pipe has been dispatched, in order of priority.
     * @return PipeInterface The new pipe that will cause the given middleware to process the input once dispatched.
     * @throws RuntimeException If problem creating.
     */
    public function createPipeFromMiddleware(iterable $middleware): PipeInterface;
}
