<?php

declare(strict_types=1);

namespace Dhii\Pipe;

use RuntimeException;

/**
 * Something that can create a middleware that will dispatch other middleware in the form of callbacks when processing.
 */
interface CompositeCallbackMiddlewareFactoryInterface
{
    /**
     * Creates a middleware that will dispatch other middleware in the form of callbacks when processing.
     *
     * @param iterable<callable> $callableMiddleware The callable middleware to be dispatched in this order.
     * @return MiddlewareInterface The middleware that will dispatch the callable middleware list when processing.
     * @throws RuntimeException If problem creating.
     */
    public function createMiddlewareFromMiddlewareCallbacks(iterable $callableMiddleware): MiddlewareInterface;
}
