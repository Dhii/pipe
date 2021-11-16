<?php

declare(strict_types=1);

namespace Dhii\Pipe;

/**
 * Creates a middleware from a callback.
 */
class CallbackMiddlewareFactory implements CallbackMiddlewareFactoryInterface
{

    /**
     * @inheritDoc
     */
    public function createMiddlewareFromCallback(callable $callback): MiddlewareInterface
    {
        return new CallbackMiddleware($callback);
    }
}
