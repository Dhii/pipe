<?php

declare(strict_types=1);

namespace Dhii\Pipe\Exception;

use Dhii\Pipe\MiddlewareInterface;
use RuntimeException;
use Throwable;

/**
 * A problem with a middleware.
 */
class MiddlewareException extends RuntimeException implements MiddlewareExceptionInterface
{
    /**
     * @var MiddlewareInterface
     */
    protected $middleware;

    public function __construct(
        string $message,
        MiddlewareInterface $middleware,
        Throwable $previous = null,
        int $code = 0
    ) {
        parent::__construct($message, $code, $previous);
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
