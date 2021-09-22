<?php
namespace PHPeacock\Framework\Structures;

/**
 * Abstract collection of elements.
 */
abstract class Collection implements \Iterator, \Countable
{
    /**
     * Elements storage.
     * @var \SplObjectStorage $elements
     */
    protected \SplObjectStorage $elements;

    /**
     * @param object $elements,... Elements to add.
     */
    public function __construct(object ...$elements)
    {
        $this->elements = new \SplObjectStorage();
        foreach ($elements as $element)
        {
            $this->elements->attach(object: $element);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function count(): int
    {
        return $this->elements->count();
    }

    /**
     * {@inheritDoc}
     */
    public function rewind(): void
    {
        $this->elements->rewind();
    }

    /**
     * {@inheritDoc}
     */
    public function current(): object
    {
        return $this->elements->current();
    }

    /**
     * {@inheritDoc}
     */
    public function key(): int
    {
        return $this->elements->key();
    }

    /**
     * {@inheritDoc}
     */
    public function next(): void
    {
        $this->elements->next();
    }

    /**
     * {@inheritDoc}
     */
    public function valid(): bool
    {
        return $this->elements->valid();
    }
}
