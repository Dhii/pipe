<?php

declare(strict_types=1);

namespace Dhii\Pipe\Exception;

interface DispatchExceptionInterface extends
    PipeExceptionInterface,
    MiddlewareExceptionInterface
{

}
