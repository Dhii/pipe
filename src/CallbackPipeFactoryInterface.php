<?php

declare(strict_types=1);

namespace Dhii\Pipe;

use RuntimeException;

/**
 * Something that can crete a pipe, using callables as middleware.
 *
 * @template Input
 * @psalm-import-type CallableMiddleware from CallbackMiddlewareFactoryInterface
 */
interface CallbackPipeFactoryInterface
{
    /**
     * Creates a pipe using callbacks as middleware.
     *
     * @param iterable<callable> $callbacks The list of middleware callbacks for the pipe, in order of processing.
     * @psalm-param iterable<CallableMiddleware>
     * @return PipeInterface The new pipe that will cause the given middleware callbacks to process the input.
     * @throws RuntimeException If problem creating.
     */
    public function createPipeFromCallbacks(iterable $callbacks): PipeInterface;
}
