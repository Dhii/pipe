<?php

declare(strict_types=1);

namespace Dhii\Pipe;

use RuntimeException;

/**
 * @template Input
 * @template Output
 * @psalm-type CallableMiddleware = callable(\Input, callable(\Input)): \Output
 */
class CompositeCallbackMiddlewareFactory implements CompositeCallbackMiddlewareFactoryInterface
{
    /**
     * @var CallbackPipeFactoryInterface
     */
    protected $callbackPipeFactory;
    /**
     * @var PipeMiddlewareFactoryInterface
     */
    protected $pipeMiddlewareFactory;

    public function __construct(
        CallbackPipeFactoryInterface $callbackPipeFactory,
        PipeMiddlewareFactoryInterface $pipeMiddlewareFactory
    ) {

        $this->callbackPipeFactory = $callbackPipeFactory;
        $this->pipeMiddlewareFactory = $pipeMiddlewareFactory;
    }

    /**
     * @inheritDoc
     */
    public function createMiddlewareFromMiddlewareCallbacks(iterable $callableMiddleware): MiddlewareInterface
    {
        $pipe = $this->createPipeFromCallableMiddlewares($callableMiddleware);
        $composite = $this->createMiddlewareFromPipe($pipe);

        return $composite;
    }

    /**
     * Creates a pipe using callbacks as middleware.
     *
     * @see CallbackPipeFactoryInterface::createPipeFromCallbacks()
     * @param iterable<callable> $callableMiddleware The list of middleware callbacks for the pipe,
     *                                               in order of processing.
     * @psalm-param iterable<CallableMiddleware>
     * @return PipeInterface The new pipe that will cause the given middleware callbacks to process the input.
     * @throws RuntimeException If problem creating.
     */
    protected function createPipeFromCallableMiddlewares(iterable $callableMiddleware): PipeInterface
    {
        return $this->callbackPipeFactory->createPipeFromCallbacks($callableMiddleware);
    }

    /**
     * Creates a middleware that dispatches a pipe when processing.
     *
     * @see PipeMiddlewareFactoryInterface::createMiddlewareFromPipe()
     * @param PipeInterface $pipe The pipe to create a middleware from.
     * @return MiddlewareInterface The new middleware that will dispatch the given pipe.
     * @throws RuntimeException If problem creating.
     */
    protected function createMiddlewareFromPipe(PipeInterface $pipe): MiddlewareInterface
    {
        return $this->pipeMiddlewareFactory->createMiddlewareFromPipe($pipe);
    }
}
