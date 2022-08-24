<?php

declare(strict_types=1);

namespace Tatter\Repositories\Objects;

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
 * - define any necessary validation method
 *
 * @immutable
 */
abstract class ValueObject
{
    abstract public static function equals(ValueObject $one, ValueObject $two): bool;
}
