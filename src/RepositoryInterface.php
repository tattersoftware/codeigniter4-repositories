<?php

declare(strict_types=1);

namespace Tatter\Repositories;

/**
 * @template TEntity of Entity
 */
interface RepositoryInterface
{
    /**
     * Gets an item from persistence by its ID.
     *
     * @return TEntity|null
     */
    public function get(int|string $id): ?Entity;

    /**
     * Gets all items, optionally filtering on the set of criteria.
     *
     * @param Condition[] $conditions
     *
     * @return iterable<TEntity>
     */
    public function list(array $conditions = []): iterable;

    /**
     * Adds or updates an item in persistence.
     *
     * @param TEntity $entity
     *
     * @throws RepositoryException
     */
    public function save(Entity $entity): void;

    /**
     * Removes an item from persistence.
     *
     * @param TEntity $entity
     *
     * @throws RepositoryException
     */
    public function remove(Entity $entity): void;
}
