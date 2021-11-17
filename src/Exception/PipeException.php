<?php

declare(strict_types=1);

namespace Dhii\Pipe\Exception;

use Dhii\Pipe\PipeInterface;
use Exception;
use Throwable;

/**
 * A problem with a pipe.
 */
class PipeException extends Exception implements PipeExceptionInterface
{
    /** @var PipeInterface */
    protected $pipe;

    public function __construct(string $message, PipeInterface $pipe, Throwable $previous = null, $code = 0)
    {
        parent::__construct($message, $code, $previous);
        $this->pipe = $pipe;
    }

    /**
     * @inheritDoc
     */
    public function getPipe(): PipeInterface
    {
        return $this->pipe;
    }
}
