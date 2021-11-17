<?php

namespace Dhii\Pipe\Exception;

use Dhii\Pipe\MiddlewareInterface;
use Dhii\Pipe\PipeInterface;
use Throwable;

/**
 * Problem during dispatch.
 */
class DispatchException extends PipeException implements DispatchExceptionInterface
{
    /** @var MiddlewareInterface */
    protected $middleware;

    public function __construct(
        string $message,
        PipeInterface $pipe,
        MiddlewareInterface $middleware,
        Throwable $previous = null,
        $code = 0
    ) {
        parent::__construct($message, $pipe, $previous, $code);
        $this->middleware = $middleware;
    }

    /**
     * @inheritDoc
     */
    public function getMiddleware(): MiddlewareInterface
    {
        return $this->middleware;
    }
}
