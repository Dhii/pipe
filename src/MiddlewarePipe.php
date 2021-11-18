<?php

declare(strict_types=1);

namespace Dhii\Pipe;

use ArrayIterator;
use Dhii\Pipe\Exception\DispatchException;
use Dhii\Pipe\Exception\DispatchExceptionInterface;
use Dhii\Pipe\Exception\PipeException;
use Exception;
use Iterator;
use IteratorIterator;
use RuntimeException;
use Traversable;

/**
 * A pipe that dispatches middlewares.
 *
 * @template Input
 * @template Output
 * @psalm-type Next = callable(\Input): \Output
 */
class MiddlewarePipe implements PipeInterface
{
    /** @var iterable<MiddlewareInterface> */
    protected $middlewares;

    /**
     * @param iterable<MiddlewareInterface> $middlewares
     */
    public function __construct(iterable $middlewares)
    {
        $this->middlewares = $middlewares;
    }

    /**
     * @inheritDoc
     */
    public function dispatch($input)
    {
        try {
            $middlewares = $this->middlewares;
            $finally =
                /**
                 * The last middleware's next step, which simply returns the input.
                 *
                 * @psalm-suppress InvalidReturnType
                 * @psalm-param \Input $input
                 * @psalm-return \Input
                 */
                function ($input) {
                    return $input;
                };
            $callback = $this->createNextCallbackChain($middlewares, $finally);
            $output = $callback($input);
        } catch (Exception $e) {
            if ($e instanceof DispatchExceptionInterface) {
                throw $e;
            }

            throw new PipeException(
                'Could not dispatch middleware pipe',
                $this,
                $e
            );
        }
        return $output;
    }

    /**
     * Creates a callback that executes a list of middlewares.
     *
     * @param iterable<MiddlewareInterface> $middlewares The list of middlewares
     * @param callable $finally The callable to run at the end of the chain.
     * @psalm-param \Next $finally
     * @return callable A callable that will start the chain.
     * @psalm-return \Next
     * @throws RuntimeException If problem creating.
     */
    protected function createNextCallbackChain(
        iterable $middlewares,
        callable $finally,
        int $currentIndex = 0
    ): callable {
        $middlewares = $this->normalizeIterator($middlewares);

        if (!$currentIndex) {
            $middlewares->rewind();
        } else {
            $middlewares->next();
        }

        if (!$middlewares->valid()) {
            return $finally;
        }

        $middleware = $middlewares->current();

        $callback =
            /**
             * The function that processes the middleware chain.
             *
             * @param mixed $input
             * @psalm-param \Input $input
             * @return mixed
             * @psalm-return \Output
             * @throws DispatchExceptionInterface If problem processing.
             */
            function ($input) use ($middleware, $middlewares, $finally, $currentIndex) {
                try {
                    $nextIndex = $currentIndex + 1;
                    return $middleware->process(
                        $input,
                        $this->createNextCallbackChain($middlewares, $finally, $nextIndex)
                    );
                } catch (Exception $e) {
                    throw new DispatchException(
                        sprintf('An error has occurred while processing middleware at index "%1$d"', $currentIndex),
                        $this,
                        $middleware,
                        $e
                    );
                }
            };

        return $callback;
    }

    /**
     * @param iterable<mixed> $iterator
     * @template Element
     * @psalm-param iterable<\Element>
     * @psalm-return Iterator<\Element>
     */
    protected function normalizeIterator(iterable $iterator): Iterator
    {
        $iterator = $this->normalizeTraversable($iterator);
        if (!$iterator instanceof Iterator) {
            $iterator = new IteratorIterator($iterator);
        }

        return $iterator;
    }

    /**
     * @template ELement
     * @param iterable<mixed> $traversable
     * @psalm-param iterable<\ELement>
     * @psalm-return Traversable<\Element>
     */
    protected function normalizeTraversable(iterable $traversable): Traversable
    {
        if (!$traversable instanceof Traversable) {
            $traversable = new ArrayIterator($traversable);
        }

        return $traversable;
    }
}
