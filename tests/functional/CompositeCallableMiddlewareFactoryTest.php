<?php

declare(strict_types=1);

namespace Dhii\Pipe\Test\Func;

use Dhii\Pipe\CallbackPipeFactoryInterface;
use Dhii\Pipe\CompositeCallbackMiddlewareFactoryInterface as Subject;
use Dhii\Pipe\CallbackMiddlewareFactoryInterface;
use Dhii\Pipe\PipeMiddlewareFactoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @psalm-import-type CallableMiddleware from CallbackMiddlewareFactoryInterface
 */
class CompositeCallableMiddlewareFactoryTest extends TestCase
{
    /**
     * @return Subject|MockObject The new mock of the test subject.
     */
    protected function createSubject(
        CallbackPipeFactoryInterface   $callbackPipeFactory,
        PipeMiddlewareFactoryInterface $pipeMiddlewareFactory
    ): Subject {
        $mock = $this->getMockBuilder(Subject::class)
            ->enableProxyingToOriginalMethods()
            ->setConstructorArgs([$callbackPipeFactory, $pipeMiddlewareFactory])
            ->getMock();

        return $mock;
    }

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

            $callbackPipeFactory = $this->createCallbackPipeFactory();
            $pipeMiddlewareFactory = $this->createPipeMiddlewareFactory();
            $subject = $this->createSubject($callbackPipeFactory, $pipeMiddlewareFactory);
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
