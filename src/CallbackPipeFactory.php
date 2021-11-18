<?php

declare(strict_types=1);

namespace Dhii\Pipe;

use RuntimeException;
use Traversable;

/**
 * A factory that creates a pipe out of callbacks.
 *
 * @template Input
 * @template Output
 * @psalm-type Next = callable(\Input): \Output
 * @psalm-type CallableMiddleware = callable(\Input, \Next): \Output
 */
class CallbackPipeFactory implements CallbackPipeFactoryInterface
{
    /** @var CallbackMiddlewareFactoryInterface */
    protected $callbackMiddlewareFactory;

    /** @var MiddlewarePipeFactoryInterface */
    protected $middlewarePipeFactory;

    public function __construct(
        CallbackMiddlewareFactoryInterface $callbackMiddlewareFactory,
        MiddlewarePipeFactoryInterface $middlewarePipeFactory
    ) {
        $this->callbackMiddlewareFactory = $callbackMiddlewareFactory;
        $this->middlewarePipeFactory = $middlewarePipeFactory;
    }

    /**
     * @inheritDoc
     */
    public function createPipeFromCallbacks(iterable $callbacks): PipeInterface
    {
        $middlewares = $this->getCallbackMiddlewareIterator($callbacks);
        $pipe = $this->createPipeFromMiddlewares($middlewares);

        return $pipe;
    }

    /**
     * Retrieves an iterator that will yield callback middlewares for the given callbacks.
     *
     * @param iterable<callable> $callbacks The callbacks to yield the middlewares for.
     * @psalm-param iterable<CallableMiddleware>
     * @return iterable<MiddlewareInterface> The iterator that will yield middlewares.
     * @throws RuntimeException If problem retrieving.
     */
    protected function getCallbackMiddlewareIterator(iterable $callbacks): iterable
    {
        return new MapIterator($this->normalizeTraversable($callbacks), function (callable $callback) {
            return $this->createMiddlewareFromCallback($callback);
        });
    }

    /**
     * Makes sure that the given list is a {@see Traversable}.
     *
     * @param iterable<mixed> $iterable The list.
     * @template Element
     * @psalm-param iterable<Element>
     * @return Traversable<mixed> The traversable.
     * @psalm-return Traversable<Element>
     * @throws RuntimeException If problem normalizing.
     */
    protected function normalizeTraversable(iterable $iterable): Traversable
    {
        yield from $iterable;
    }

    /**
     * Creates a middleware that will invoke the given callback for processing.
     *
     * @param callable $callback The callback to invoke for processing.
     * @psalm-param CallableMiddleware
     * @return MiddlewareInterface The middleware.
     * @throws RuntimeException If problem creating.
     */
    protected function createMiddlewareFromCallback(callable $callback): MiddlewareInterface
    {
        return $this->callbackMiddlewareFactory->createMiddlewareFromCallback($callback);
    }

    /**
     * Creates a pipe that will invoke the given middlewares when dispatched.
     *
     * @param iterable<MiddlewareInterface> $middlewares The middlewares that will be invoked.
     * @return PipeInterface The pipe that will invoke the given middlewares.
     * @throws RuntimeException If problem creating.
     */
    protected function createPipeFromMiddlewares(iterable $middlewares): PipeInterface
    {
        return $this->middlewarePipeFactory->createPipeFromMiddleware($middlewares);
    }
}
