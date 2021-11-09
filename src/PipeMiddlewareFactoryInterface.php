<?php

declare(strict_types=1);

namespace Dhii\Pipe;

use RuntimeException;

/**
 * Something that can create a middleware that will dispatch a pipe when processing.
 */
interface PipeMiddlewareFactoryInterface
{
    /**
     * Creates a middleware that dispatches a pipe when processing.
     *
     * @param PipeInterface $pipe The pipe to create a middleware from.
     * @return MiddlewareInterface The new middleware that will dispatch the given pipe.
     * @throws RuntimeException If problem creating.
     */
    public function createMiddlewareFromPipe(PipeInterface $pipe): MiddlewareInterface;
}
