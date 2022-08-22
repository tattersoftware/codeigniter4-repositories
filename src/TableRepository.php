<?php

declare(strict_types=1);

namespace Tatter\Repositories;

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


    public function save($data): bool
    {
        if (empty($data)) {
            return true;
        }

        if ($this->shouldUpdate($data)) {
            $response = $this->update($this->getIdValue($data), $data);
        } else {
            $response = $this->insert($data, false);

            if ($response !== false) {
                $response = true;
            }
        }

        return $response;
    }

    /**
     * This method is called on save to determine if entry have to be updated
     * If this method return false insert operation will be executed
     *
     * @param array|object $data Data
     */
    protected function shouldUpdate($data): bool
    {
        return ! empty($this->getIdValue($data));
    }

    /**
     * Inserts data into the database. If an object is provided,
     * it will attempt to convert it to an array.
     *
     * @param array|object|null $data
     * @param bool              $returnID Whether insert ID should be returned or not.
     *
     * @throws ReflectionException
     *
     * @return BaseResult|false|int|object|string
     */
    public function insert($data = null, bool $returnID = true)
    {
        if (! empty($this->tempData['data'])) {
            if (empty($data)) {
                $data = $this->tempData['data'] ?? null;
            } else {
                $data = $this->transformDataToArray($data, 'insert');
                $data = array_merge($this->tempData['data'], $data);
            }
        }

        $this->escape   = $this->tempData['escape'] ?? [];
        $this->tempData = [];

        return parent::insert($data, $returnID);
    }

    /**
     * Updates a single record in the database. If an object is provided,
     * it will attempt to convert it into an array.
     *
     * @param array|int|string|null $id
     * @param array|object|null     $data
     *
     * @throws ReflectionException
     */
    public function update($id = null, $data = null): bool
    {
        if (! empty($this->tempData['data'])) {
            if (empty($data)) {
                $data = $this->tempData['data'] ?? null;
            } else {
                $data = $this->transformDataToArray($data, 'update');
                $data = array_merge($this->tempData['data'], $data);
            }
        }

        $this->escape   = $this->tempData['escape'] ?? [];
        $this->tempData = [];

        return parent::update($id, $data);
    }


    protected function doDelete($id = null, bool $purge = false)
    {
        $builder = $this->builder();

        if ($id) {
            $builder = $builder->whereIn($this->primaryKey, $id);
        }

        if ($this->useSoftDeletes && ! $purge) {
            if (empty($builder->getCompiledQBWhere())) {
                if (CI_DEBUG) {
                    throw new DatabaseException(
                        'Deletes are not allowed unless they contain a "where" or "like" clause.'
                    );
                }

                return false; // @codeCoverageIgnore
            }

            $builder->where($this->deletedField);

            $set[$this->deletedField] = $this->setDate();

            if ($this->useTimestamps && $this->updatedField) {
                $set[$this->updatedField] = $this->setDate();
            }

            return $builder->update($set);
        }

        return $builder->delete();
    }    