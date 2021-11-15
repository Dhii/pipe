<?php

declare(strict_types=1);

namespace Dhii\Pipe;

use IteratorIterator;
use Traversable;

/**
 * Maps values before yielding.
 *
 * @link https://github.com/Guzzle3/iterator/blob/master/MapIterator.php
 *
 * @template Element
 * @template Result
 * @psalm-type ElementCallback = callable(\Element): \Result
 */
class MapIterator extends IteratorIterator
{
    /**
     * @var callable
     * @psalm-var ElementCallback
     */
    protected $callback;

    /**
     * @param Traversable<Element> $iterator The iterator to map the items of.
     * @param callable $callback Callback used for iterating.
     * @psalm-param ElementCallback $callback
     */
    public function __construct(Traversable $iterator, callable $callback)
    {
        parent::__construct($iterator);
        $this->callback = $callback;
    }

    /**
     * @inheritDoc
     * @psalm-return Result The element after applying the callback to it.
     */
    public function current()
    {
        $callback = $this->callback;
        return $callback(parent::current());
    }
}
