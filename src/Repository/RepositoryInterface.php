<?php

declare(strict_types=1);

namespace Tatter\Repositories\Repository;

use Tatter\Repositories\Conditions\Conditions;
use Tatter\Repositories\Objects\Entity;

/**
 * @template T of Entity
 */
interface RepositoryInterface
{
    /**
     * Gets an item from persistence by its ID.
     *
     * @param int|string $id
     *
     * @return T|null
     */
    public function get($id): ?Entity;

    /**
     * Gets all items, optionally filtering on the set of criteria.
     *
     * @return iterable<T>
     */
    public function list(?Conditions $conditions = null): iterable;

    /**
     * Adds or updates an item in persistence.
     *
     * @param T $entity
     *
     * @throws RepositoryException
     */
    public function save(Entity $entity): void;

    /**
     * Removes an item from persistence.
     *
     * @param T $entity
     *
     * @throws RepositoryException
     */
    public function remove(Entity $entity): void;
}
