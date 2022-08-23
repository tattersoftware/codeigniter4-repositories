<?php

declare(strict_types=1);

namespace Tatter\Repositories;

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
    public static function equals(static $one, static $two): bool;

    /**
     * @throws InvalidArgumentException
     */
    protected static function validate()
    {
    }

    /**
     * Casts this into a values array for persistence.
     * Can be multiple key-value pairs.
     *
     * @return array<string, mixed>
     */
    abstract public function toArray(): array;
}
