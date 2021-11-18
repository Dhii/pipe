<?php

declare(strict_types=1);

namespace Dhii\Pipe\Test\Func;

use Dhii\Pipe\CallbackMiddlewareFactory;
use Dhii\Pipe\CallbackPipeFactory;
use Dhii\Pipe\CallbackPipeFactoryInterface;
use Dhii\Pipe\CompositeCallbackMiddlewareFactory as Subject;
use Dhii\Pipe\CallbackMiddlewareFactoryInterface;
use Dhii\Pipe\MiddlewarePipeFactory;
use Dhii\Pipe\MiddlewarePipeFactoryInterface;
use Dhii\Pipe\PipeMiddlewareFactory;
use Dhii\Pipe\PipeMiddlewareFactoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @psalm-import-type CallableMiddleware from CallbackMiddlewareFactoryInterface
 */
class CompositeCallableMiddlewareFactoryTest extends TestCase
{
    /**
     * @return Subject&MockObject The new mock of the test subject.
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
            $middlewareA = function (string $input, callable $next) {
                $result = $next($input);
                $result[] = 'A';

                return $result;
            };
            $middlewareB = function (string $input, callable $next) {
                $result = $next($input);
                $result[] = 'B';

                return $result;
            };
            $middlewareEnd = function (string $input, callable $next) { return [$input]; };
            $middleware = [$middlewareA, $middlewareB, $middlewareEnd];
            $final = function (string $input) { return $input; };

            $callbackMiddlewareFactory = $this->createCallbackMiddlewareFactory();
            $middlewarePipeFactory = $this->createMiddlewarePipeFactory();
            $callbackPipeFactory = $this->createCallbackPipeFactory($callbackMiddlewareFactory, $middlewarePipeFactory);
            $pipeMiddlewareFactory = $this->createPipeMiddlewareFactory();
            $subject = $this->createSubject($callbackPipeFactory, $pipeMiddlewareFactory);
        }

        {
            $middleware = $subject->createMiddlewareFromMiddlewareCallbacks($middleware);
            $result = $middleware->process($input, $final);
        }

        {
            $this->assertEquals([$input,'B', 'A'], $result);
        }
    }

    /**
     * @param CallbackMiddlewareFactoryInterface $callbackMiddlewareFactory
     * @param MiddlewarePipeFactoryInterface $middlewarePipeFactory
     * @return CallbackPipeFactoryInterface&MockObject
     */
    protected function createCallbackPipeFactory(
        CallbackMiddlewareFactoryInterface $callbackMiddlewareFactory,
        MiddlewarePipeFactoryInterface $middlewarePipeFactory
    ): CallbackPipeFactoryInterface {
        $mock = $this->getMockBuilder(CallbackPipeFactory::class)
            ->enableProxyingToOriginalMethods()
            ->setConstructorArgs([$callbackMiddlewareFactory, $middlewarePipeFactory])
            ->getMock();

        return $mock;
    }

    /**
     * @return CallbackMiddlewareFactoryInterface&MockObject
     */
    protected function createCallbackMiddlewareFactory(): CallbackMiddlewareFactoryInterface
    {
        $mock = $this->getMockBuilder(CallbackMiddlewareFactory::class)
            ->enableProxyingToOriginalMethods()
            ->getMock();

        return $mock;
    }

    /**
     * @return MiddlewarePipeFactoryInterface&MockObject
     */
    protected function createMiddlewarePipeFactory(): MiddlewarePipeFactoryInterface
    {
        $mock = $this->getMockBuilder(MiddlewarePipeFactory::class)
            ->enableProxyingToOriginalMethods()
            ->getMock();

        return $mock;
    }

    /**
     * @return PipeMiddlewareFactoryInterface&MockObject
     */
    protected function createPipeMiddlewareFactory(): PipeMiddlewareFactoryInterface
    {
        $mock = $this->getMockBuilder(PipeMiddlewareFactory::class)
            ->enableProxyingToOriginalMethods()
            ->getMock();

        return $mock;
    }
}
