<?php

declare(strict_types=1);

namespace Dhii\Pipe;

class MiddlewarePipeFactory implements MiddlewarePipeFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createPipeFromMiddleware(iterable $middleware): PipeInterface
    {
        return new MiddlewarePipe($middleware);
    }
}
