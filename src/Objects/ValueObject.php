<?php

declare(strict_types=1);

namespace Tatter\Repositories\Objects;

use InvalidArgumentException;

/**
 * Value Object Class
 *
 * Used to implement complex values, composite values,
 * value persistence casting, or self-validation.
 * Most of the time implementing classes should:
 * - be final
 * - be immutable
 * - have a private constructor to set values and validate
 * - have one or more static named construction methods
 * - have only private properties with getters
 * - define a proper validate() method
 */
#[Immutable]
abstract class ValueObject
{
    /**
     * $var static $one
     * $var static $two
     */
    public static function equals(ValueObject $one, ValueObject $two): bool
    {
        $array1 = $one->toArray();
        $array2 = $two->toArray();

        array_multisort($array1);
        array_multisort($array2);

        return serialize($array1) === serialize($array2);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected static function validate(): void
    {
    }

    /**
     * Casts this into a values array (e.g. for persistence).
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return (array) $this;
    }
}
