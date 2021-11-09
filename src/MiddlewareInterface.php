<?php

declare(strict_types=1);

namespace Dhii\Pipe;

use RuntimeException;

/**
 * @template I
 * @template O
 */
interface MiddlewareInterface
{
    /**
     * Process the inpyt and produce output.
     *
     * @param mixed $input The input to process.
     * @psalm-param I $input
     * @param callable $next Processes the input by the next middleware in the stack.
     * @return mixed
     * @psalm-return O
     * @throws RuntimeException If problem processing.
     */
    public function process($input, callable $next);
}
