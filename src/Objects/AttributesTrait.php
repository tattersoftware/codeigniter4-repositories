<?php

declare(strict_types=1);

namespace Tatter\Repositories\Objects;

use OutOfBoundsException;

/**
 * Attributes Trait
 *
 * Adds a protected attributes property with
 * read-only access via magic methods.
 */
trait AttributesTrait
{
    /**
     * @var array<string, mixed>
     */
    protected $attributes;

    /**
     * Sets attributes from an array in one swoop.
     */
    public static function fromArray(array $array): static
    {
        return new static($array);
    }

    final protected function __construct($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Gets an attribute.
     *
     * @throws OutOfBoundsException
     *
     * @return mixed
     */
    final public function __get(string $key)
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }

        throw new OutOfBoundsException('Undefined property: ' . self::class . "::{$key}");
    }

    /**
     * Checks existence of an attribute.
     */
    final public function __isset(string $key): bool
    {
        return isset($this->attributes[$key]);
    }

    /**
     * Gets the attributes.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->attributes;
    }
}
