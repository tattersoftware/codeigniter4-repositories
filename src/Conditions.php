<?php

declare(strict_types=1);

namespace Tatter\Repositories;

use InvalidArgumentException;
use IteratorAggregate;

class Conditions implements IteratorAggregate
{
    protected array $conditions;

    public function __construct(Condition ...$conditions)
    {
        $this->conditions = $conditions;
    }
    
    public getIterator(): array
    {
        return $this->conditions;
    }
}
