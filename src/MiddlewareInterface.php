<?php

declare(strict_types=1);

namespace Dhii\Pipe;

use RuntimeException;

/**
 * @template Input
 * @template Output
 * @psalm-type Next = callable(\Input): \Output
 */
interface MiddlewareInterface
{
    /**
     * Process the inpyt and produce output.
     *
     * @param mixed $input The input to process.
     * @psalm-param \Input $input
     * @param callable $next Processes the input by the next middleware in the stack.
     * @psalm-param Next $next
     * @return mixed
     * @psalm-return \Output
     * @throws RuntimeException If problem processing.
     */
    public function process($input, callable $next);
}
