<?php

declare(strict_types=1);

namespace Dhii\Pipe\Test\Func;

use Dhii\Pipe\CompositeCallbackMiddlewareFactoryInterface;
use PHPUnit\Framework\TestCase;

class CompositeCallableMiddlewareFactoryTest extends TestCase
{
    public function testCreateMiddlewareFromMiddleware()
    {
        {
            $input = uniqid('input');
            $middlewareStart = function ($input, callable $next) use (&$sequence) { yield $input; yield from $next($input); };
            $middlewareA = function ($input, callable $next) use (&$sequence) { yield 'A'; yield from $next($input); };
            $middlewareB = function ($input, callable $next) use (&$sequence) { yield 'B'; yield from $next($input); };
            $middlewareEnd = function ($input, callable $next) use (&$sequence) { return []; };
            $middleware = [$middlewareStart, $middlewareA, $middlewareB, $middlewareEnd];
            $final = function () use (&$sequence) { $sequence[] = '.'; };
            $subject = $this->createSubject($middleware);
            /** @var $subject CompositeCallbackMiddlewareFactoryInterface */
        }

        {
            $middleware = $subject->createMiddlewareFromMiddlewareCallbacks($middleware);
            $result = $middleware->process($input, $final);
        }

        {
            $this->assertEquals([$input, 'A', 'B', '.'], $result);
        }
    }
}
