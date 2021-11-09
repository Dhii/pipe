<?php

declare(strict_types=1);

namespace Dhii\Pipe;

use Exception;

/**
 * Something that exposes a pipe.
 */
interface PipeAwareInterface
{
    /**
     * Retrieves the pipe associated with this instance.
     *
     * @return PipeInterface The pipe.
     * @throws Exception If problem retrieving.
     */
    public function getPipe(): PipeInterface;
}
