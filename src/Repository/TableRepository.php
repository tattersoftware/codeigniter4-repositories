<?php

declare(strict_types=1);

namespace Tatter\Repositories\Repository;

use CodeIgniter\Database\BaseConnection;

/**
 * @template T of Entity
 */
abstract class TableRepository implements RepositoryInterface
{
    /**
     * @var class-string<T>
     */
    public const ENTITY = '';
    public const TABLE  = '';

    protected BaseConnection $connection;

    public function __construct(BaseConnection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Gets an item from persistence by its ID.
     *
     * @param int|string $id
     */
    public function get($id): ?Entity
    {
        return $this->connection
            ->table(static::TABLE)
            ->where(static::TABLE . '.' . static::ENTITY::IDENTIFIER, $id)
            ->get()
            ->getFirstRow(static::ENTITY);
    }

    /**
     * Gets all items, optionally filtering on the set of criteria.
     *
     * @returns iterable<T>
     */
    public function list(Criteria $criteria = null): iterable
    {
    }

    /**
     * Adds or updates an item in persistence.
     *
     * @param T $entity
     *
     * @throws RepositoryException
     */
    public function save(Entity $entity)
    {
        $entity->getId() === null
            ? $this->insert($entity->toArray())
            : $this->update($entity->getId(), $entity->toArray());
    }

    /**
     * Inserts a new row into the database.
     *
     * @param array<string, mixed> $data
     */
    protected function insert(array $data): void
    {
        return $this->connection
            ->table(static::TABLE)
            ->insert($data);
    }

    /**
     * Updates the row in the database.
     *
     * @param string|int $id
     * @param array<string, mixed> $data
     */
    protected function update($id, array $data): void
    {
        return $this->connection
            ->table(static::TABLE)
            ->update($data, [
                static::ENTITY::IDENTIFIER => $id,
            ]);
    }

    /**
     * Removes an item from persistence.
     *
     * @param T $entity
     *
     * @throws RepositoryException
     */
    public function remove(Entity $entity);
    {
        return $this->connection
            ->table(static::TABLE)
            ->where($entity::IDENTIFIER, $entity->getId())
            ->delete();
    }

    /**
     * Removes matching items from persistence.
     *
     * @throws RepositoryException
     */
    public function removeWhere(Criteria $criteria)
    {
    }
}
