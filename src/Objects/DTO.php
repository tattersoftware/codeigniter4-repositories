<?php

declare(strict_types=1);

namespace Tatter\Repositories\Objects;

/**
 * Data Transfer Object Class
 *
 * Used to pass data between layers.
 *
 * @immutable
 */
final class DTO extends ValueObject
{
    use AttributesTrait;

    /**
     * @param self $one
     * @param self $two
     */
    public static function equals(ValueObject $one, ValueObject $two): bool
    {
        $array1 = $one->toArray();
        $array2 = $two->toArray();

        array_multisort($array1);
        array_multisort($array2);

        return serialize($array1) === serialize($array2);
    }
}
