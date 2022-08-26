<?php

declare(strict_types=1);

namespace Tatter\Repositories;

use InvalidArgumentException;
use Tatter\Repositories\Repository\Entity;

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

    private string $operator;

    /**
     * @var array<int, scalar|null>|scalar|null
     */
    private array|bool|string|int|float|null $value;

    public static function fromString(string $input): self
    {
        $segments = explode(' ', $input);
        if (count($segments) < 3) {
            throw new InvalidArgumentException('Invalid condition string: ' . $input);
        }

        $field    = array_shift($segments);
        $operator = array_shift($segments);
        $value    = implode(' ', $segments);

        return new self($field, $operator, $value);
    }

    /**
     * Returns a condition to match an Entity by the given identifier.
     *
     * @param class-string<Entity> $class
     */
    public static function fromIdentity(string $class, int|string $id): self
    {
        return new self($class::IDENTIFIER, '=', $id);
    }

    /**
     * @param array<int, scalar|null>|scalar|null $value
     */
    public function __construct(private string $field, string $operator, $value)
    {
        if (! in_array($operator, self::OPERATORS, true)) {
            throw new InvalidArgumentException('Unknown conditional operation: ' . $operator);
        }

        // Only allow arrays for array operators
        if (is_array($value) && ! in_array($operator, ['in', '!in'], true)) {
            throw new InvalidArgumentException('Invalid array operator: ' . $operator);
        }
        $this->operator = $operator;
        $this->value    = $value;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    /**
     * @return array<int, scalar|null>|scalar|null
     */
    public function getValue()
    {
        return $this->value;
    }
}
