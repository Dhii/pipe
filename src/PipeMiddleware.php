<?php

declare(strict_types=1);

namespace Dhii\Pipe;

/**
 * A middleware that will dispatch a pipe when processing.
 *
 * @template Input
 * @template Output
 * @psalm-type Next = callable(\Input): \Output
 */
class PipeMiddleware implements MiddlewareInterface
{
    /** @var PipeInterface<\Input, \Output> */
    protected $pipe;

    /**
     * @param PipeInterface $pipe
     * @psalm-param PipeInterface<\Input, \Output>
     */
    public function __construct(PipeInterface $pipe)
    {
        $this->pipe = $pipe;
    }

    /**
     * @inheritDoc
     */
    public function process($input, callable $next)
    {
        return $this->pipe->dispatch($input);
    }
}
