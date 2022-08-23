<?php

declare(strict_types=1);

namespace Tatter\Repositories;

use InvalidArgumentException;

final class Condition
{
    public const OPERATORS = [
        '=',
        '!=',
        '>',
        '>=',
        '<',
        '<=',
        'in',
        '!in',
    ];

    private string $field;
    private string $operator;
    
    /**
     * @var scalar|null
     */
    private $value;

    public static function fromString(string $input): self
    {
        $segments = explode(' ', $input);
        if (count($segments < 3)) {
            throw new InvalidArgumentException('Invalid condition string: ' . $input);
        }
        
        $field    = array_shift($segments);
        $operator = array_shift($segments);
        $value    = implode(' ', $segments);

        return new self($field, $operator, $value);
    }

    public function __construct(string $field, string $operator, $value)
    {
        if (! in_array($operator, self::OPERATORS)) {
            throw new InvalidArgumentException('Unknown conditional operation: ' . $operator);
        }

        $this->field    = $field;
        $this->operator = $operator;
        $this->value    = $value;
    }
    
    public getField(): string
    {
        return $this->field;
    }
    
    public getOperator(): string
    {
        return $this->operator;
    }
    
    /**
     * @return scalar|null
     */
    public getValue()
    {
        return $this->value;
    }
}
