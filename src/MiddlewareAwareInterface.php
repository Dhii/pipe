<?php

declare(strict_types=1);

namespace Dhii\Pipe;

use Exception;

interface MiddlewareAwareInterface
{
    /**
     * Retrieves the middleware associated with this instance.
     *
     * @return MiddlewareInterface The middleware.
     * @throws Exception If problem retrieving.
     */
    public function getMiddleware(): MiddlewareInterface;
}
