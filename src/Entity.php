<?php

declare(strict_types=1);

namespace Tatter\Repositories;

use OutOfBoundsException;

/**
 * Abstract Entity Class
 *
 * The home of all business logic for an identity object.
 * Override fromArray() and toArray() with any special handling.
 * Be sure to leverage value objects for properties that
 * are composite or complex, or that require validation.
 */
abstract class Entity
{
    public const IDENTIFIER = 'id';

    /**
     * Returns the identity value if it exists, or null.
     *
     * @return int|string|null
     */
    final public function getId()
    {
        return $this->{static::IDENTIFIER} ?? null;
    }

    /**
     * Sets attributes from an array in one swoop.
     */
    public static function fromArray(array $array): static
    {
        return new static($array);
    }

    /**
     * @param array<string, mixed> $attributes
     */
    final protected function __construct(protected $attributes)
    {
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

        if ($key === static::IDENTIFIER) {
            return null;
        }

        throw new OutOfBoundsException('Undefined property: ' . static::class . "::{$key}");
    }

    /**
     * Sets an attribute.
     *
     * @param mixed|null $value
     */
    final public function __set(string $key, $value): void
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Checks existence of an attribute.
     */
    final public function __isset(string $key): bool
    {
        return isset($this->attributes[$key]);
    }

    /**
     * Unsets an attribute property.
     */
    final public function __unset(string $key): void
    {
        unset($this->attributes[$key]);
    }
}
