<?php

declare(strict_types=1);

namespace Dhii\Pipe;

/**
 * @template Input
 * @template Output
 * @psalm-type Next = callable(\Input): \Output
 * @psalm-type CallableMiddleware = callable(\Input, \Next): \Output
 *
 * A middleware that invokes the configured callback for processing.
 */
class CallbackMiddleware implements MiddlewareInterface
{
    /**
     * @var callable
     * @psalm-var \CallableMiddleware
     */
    protected $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @inheritDoc
     */
    public function process($input, callable $next)
    {
        $output = $this->invokeCallback($input, $next);

        return $output;
    }

    /**
     * Invokes a middleware callback, and retrieves its result.
     *
     * @param mixed $input The input to the middleware.
     * @param callable $next The function that passes control to the next middleware.
     * @psalm-param \Next $next
     * @return mixed The result of processing.
     */
    protected function invokeCallback($input, callable $next)
    {
        $callback = $this->callback;
        $result = $callback($input, $next);

        return $result;
    }
}
