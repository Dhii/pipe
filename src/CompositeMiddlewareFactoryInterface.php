<?php

declare(strict_types=1);

namespace Dhii\Pipe;

use RuntimeException;

/**
 * Something that can create a middleware that will dispatch other middleware when processing.
 */
interface CompositeMiddlewareFactoryInterface
{
    /**
     * Creates a middleware that will dispatch other middleware when processing.
     *
     * @param iterable<MiddlewareInterface> $middleware The list of middleware that will be dispatched.
     * @return MiddlewareInterface The middleware that will dispatch the given list when processing
     * @throws RuntimeException If problem creating.
     */
    public function createMiddlewareFromMiddleware(iterable $middleware): MiddlewareInterface;
}
