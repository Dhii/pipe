<?php

declare(strict_types=1);

namespace Dhii\Pipe;

use RuntimeException;

/**
 * Can create a middleware from a callback.
 *
 * @template I
 * @psalm-type CallableMiddleware = callable(I, callable(I))
 */
interface CallbackMiddlewareFactoryInterface
{
    /**
     * Creates a middleware from a callback.
     *
     * @param callable $callback The callback to be used for processing by the middleware.
     * @psalm-param CallableMiddleware $callback
     * @return MiddlewareInterface The new middleware that uses the given callback for processing.
     * @throws RuntimeException If problem creating.
     */
    public function createMiddlewareFromCallback(callable $callback): MiddlewareInterface;
}
