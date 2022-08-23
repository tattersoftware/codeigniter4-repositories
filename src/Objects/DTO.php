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
#[\AllowDynamicProperties]
final class DTO extends ValueObject
{
    /**
     * @param array<string, scalar|null> $array
     */
    public function __construct(array $array)
    {
        foreach ($array as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
