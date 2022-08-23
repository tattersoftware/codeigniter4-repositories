<?php

declare(strict_types=1);

namespace Tatter\Repositories\Objects;

use OutOfBoundsException;

/**
 * Abstract Entity Class
 *
 * The home of all business logic for an identity object.
 * Override fromArray() and toArray() with any special handling.
 * Be sure to leverage Objects\ValueObject for properties that
 * are composite or complex, or that require validation.
 */
abstract class Entity
{
    public const IDENTIFIER = 'id';

    /**
     * Sets values array properties.
     * Should handle any casting and value object conversions.
     *
     * @param array<string, scalar|null> $array
     *
     * @return static
     */
    public static function fromArray(array $array): self
    {
        return new static($array);
    }

    /**
     * Converts from a data transfer object.
     * Can be coming from persistence or user input.
     *
     * @return static
     */
    final public static function fromDTO(DTO $dto): self
    {
        return static::fromArray($dto->toArray());
    }

    final protected function __construct(protected array $attributes)
    {
    }

    /**
     * Returns the identity value if it exists, or null.
     *
     * @return int|string|null
     */
    final public function getId()
    {
        return $this->{static::IDENTIFIER};
    }

    /**
     * Gets the values array for persistence.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    /**
     * Casts the entity into a data transfer object (e.g. for persistence).
     */
    final public function toDTO(): DTO
    {
        return new DTO($this->toArray());
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
     * Unsets an attribute property.
     */
    final public function __unset(string $key): void
    {
        unset($this->attributes[$key]);
    }
}
