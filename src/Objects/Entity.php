<?php

declare(strict_types=1);

namespace Tatter\Repositories\Objects;

use OutOfBoundsException;

abstract class Entity
{
    public const IDENTIFIER = 'id';

    protected array $attributes;
   
    /**
     * Set values array properties from persistence.
     * Should handle any casting and value object conversion.
     *
     * @return array<string, scalar|null>
     */
    public static function fromArray(array $array): static
    {
        return new static($array);
    }

    private function __construct(array $array)
    {
        $this->attributes = $array;
    }

    /**
     * Returns the identity value if it exists, or null.
     *
     * @return int|string|null
     */
    public function getId()
    {
        return $this->{static::IDENTIFIER};
    }

    /**
     * Casts the entity into a values array for persistence.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->attributes;
    }
    
    /**
     * Sets an attribute.
     *
     * @param mixed|null $value
     */
    public function __set(string $key, $value): void
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Gets an attribute.
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function __get(string $key)
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }

        throw OutOfBoundsException('Undefined property: ' . get_class() . "::$key");
    }

    /**
     * Checks existence of an attribute.
     */
    public function __isset(string $key): bool
    {
        return isset($this->attributes[$key]);
    }

    /**
     * Unsets an attribute property.
     */
    public function __unset(string $key): void
    {
        unset($this->attributes[$key]);
    }
}
