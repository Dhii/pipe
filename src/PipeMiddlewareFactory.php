<?php

declare(strict_types=1);

namespace Dhii\Pipe;

class PipeMiddlewareFactory implements PipeMiddlewareFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createMiddlewareFromPipe(PipeInterface $pipe): MiddlewareInterface
    {
        return new PipeMiddleware($pipe);
    }
}
