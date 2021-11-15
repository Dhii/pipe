<?php

declare(strict_types=1);

namespace Dhii\Pipe\Test\Func;

use ArrayIterator;
use Dhii\Pipe\MapIterator as Subject;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Traversable;

class MapIteratorTest extends TestCase
{
    public function testIteration()
    {
        {
            $callback = function (int $number): int {
                return abs(10 - $number);
            };
            $numbers = [1, 2, 5, 8, 12, 39];
            $subject = $this->createSubject(new ArrayIterator($numbers), $callback);
        }

        {
            $result = iterator_to_array($subject);
        }

        {
            $this->assertEquals([9, 8, 5, 2, 2, 29], $result);
        }
    }

    /**
     * @param Traversable $elements The list of elements.
     * @param callable $callback The callback to apply to the elements.
     * @return Subject|MockObject The new test subject mock.
     */
    protected function createSubject(Traversable $elements, callable $callback): Subject
    {
        $mock = $this->getMockBuilder(Subject::class)
            ->enableProxyingToOriginalMethods()
            ->setConstructorArgs([$elements, $callback])
            ->getMock();

        return $mock;
    }
}
