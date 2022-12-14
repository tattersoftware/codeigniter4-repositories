<?php

declare(strict_types=1);

namespace Tatter\Repositories\Repositories;

use Tatter\Repositories\Condition;
use Tatter\Repositories\Entity;
use Tatter\Repositories\Persistence\SimpleBuilder;
use Tatter\Repositories\RepositoryException;
use Tatter\Repositories\RepositoryInterface;
use UnexpectedValueException;

/**
 * Table Repository Abstract Class
 *
 * A repository that sits in front of a single
 * database table, similar to CodeIgniter\Model.
 *
 * @template TEntity of Entity
 */
abstract class TableRepository implements RepositoryInterface
{
    public const TABLE  = '';
    public const ENTITY = '';

    protected SimpleBuilder $database;

    final public function __construct()
    {
        if (empty(static::TABLE)) {
            throw new UnexpectedValueException('TABLE class constant must be set!');
        }
        if (empty(static::ENTITY)) {
            throw new UnexpectedValueException('ENTITY class constant must be set!');
        }

        $this->database = SimpleBuilder::fromTableName(static::TABLE);
        $this->initialize();
    }

    /**
     * Initializes any class extension requirements after construction.
     */
    public function initialize(): void
    {
    }

    /**
     * Gets an item from persistence by its ID.
     *
     * @param int|string $id
     *
     * @return TEntity|null
     */
    public function get($id): ?Entity
    {
        $conditions = [Condition::fromIdentity(static::ENTITY, $id)];
        $result     = $this->database->first($conditions);
        if ($result === null) {
            return null;
        }

        $class = static::ENTITY;

        return $class::fromArray($result);
    }

    /**
     * Gets all items, optionally filtering on the set of criteria.
     *
     * @param Condition[] $conditions
     *
     * @returns iterable<TEntity>
     */
    public function list(array $conditions = []): iterable
    {
        $class = static::ENTITY;

        foreach ($this->database->get($conditions) as $array) {
            yield $class::fromArray($array);
        }
    }

    /**
     * Adds or updates an item in persistence.
     *
     * @param TEntity $entity
     *
     * @throws RepositoryException
     */
    public function save(Entity $entity): void
    {
        if (null === $id = $entity->getId()) {
            $this->database->insert($entity->toArray());

            return;
        }

        $conditions = [Condition::fromIdentity($entity::class, $id)];
        $this->database->update($conditions, $entity->toArray());
    }

    /**
     * Removes an item from persistence.
     *
     * @param TEntity $entity
     *
     * @throws RepositoryException
     */
    public function remove(Entity $entity): void
    {
        if (null === $id = $entity->getId()) {
            return;
        }

        $conditions = [Condition::fromIdentity($entity::class, $id)];
        $this->database->delete($conditions);
    }
}
