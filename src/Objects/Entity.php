<?php

declare(strict_types=1);

namespace Tatter\Repositories\Objects;

/**
 * Abstract Entity Class
 *
 * The home of all business logic for an identity object.
 * Override fromArray() and toArray() with any special handling.
 * Be sure to leverage ValueObjects for properties that
 * are composite or complex, or that require validation.
 */
abstract class Entity
{
    use AttributesTrait;

    public const IDENTIFIER = 'id';

    /**
     * Converts from a data transfer object.
     * Can be coming from persistence or user input.
     */
    final public static function fromDTO(DTO $dto): static
    {
        return static::fromArray($dto->toArray());
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
     * Casts the entity into a data transfer object (e.g. for persistence).
     */
    final public function toDTO(): DTO
    {
        return DTO::fromArray($this->toArray());
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
     * Unsets an attribute property.
     */
    final public function __unset(string $key): void
    {
        unset($this->attributes[$key]);
    }
}
