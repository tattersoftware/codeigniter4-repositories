<?php

declare(strict_types=1);

namespace Tatter\Repositories\Conditions;

use ArrayIterator;
use IteratorAggregate;
use Tatter\Repositories\Repository\Entity;

class Conditions implements IteratorAggregate
{
    protected array $conditions;

    /**
     * Returns a single condition to match an
     * Entity subclass by the given identifier.
     *
     * @param class-string<Entity> $class
     */
    public static function fromIdentity(string $class, int|string $id): self
    {
        $condition = new Condition($class::IDENTIFIER, '=', $id);

        return new self($condition);
    }

    public function __construct(Condition ...$conditions)
    {
        $this->conditions = $conditions;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->conditions);
    }
}
