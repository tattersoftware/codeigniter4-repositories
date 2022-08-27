<?php

declare(strict_types=1);

namespace Tatter\Repositories\Persistence;

use CodeIgniter\Database\BaseBuilder;
use Config\Database;
use Generator;
use RuntimeException;
use Tatter\Repositories\Condition;

/**
 * Simple Builder Persistence Class
 *
 * A wrapper for the Query Builder.
 */
final class SimpleBuilder
{
    /**
     * Creates a new SQL persistence object specific to a table.
     */
    public static function fromTableName(string $table): self
    {
        $builder = Database::connect()->table($table);

        return new self($builder);
    }

    private function __construct(private BaseBuilder $builder)
    {
    }

    /**
     * Gets the first row matching the conditions.
     *
     * @param Condition[] $conditions
     */
    public function first(array $conditions): ?array
    {
        $result = $this->builderFromConditions($conditions)
            ->limit(1)
            ->get();
        if ($result === false) {
            throw new RuntimeException('Query Builder result failed.');
        }

        return $result->getResultArray()[0] ?? null;
    }

    /**
     * Yields matching results from persistence.
     *
     * @param Condition[] $conditions
     *
     * @returns iterable<array>
     */
    public function get(array $conditions): Generator
    {
        $result = $this->builderFromConditions($conditions)->get();
        if ($result === false) {
            throw new RuntimeException('Query Builder result failed.');
        }

        while ($array = $result->getUnbufferedRow('array')) {
            yield $array;
        }
    }

    /**
     * Inserts a new row into the database.
     */
    public function insert(array $data): void
    {
        (clone $this->builder)->insert($data);
    }

    /**
     * Updates rows in the database.
     *
     * @param Condition[] $conditions
     */
    public function update(array $conditions, array $data): void
    {
        $this->builderFromConditions($conditions)->update($data);
    }

    /**
     * Deletes matching items from the database.
     *
     * @param Condition[] $conditions
     */
    public function delete(array $conditions): void
    {
        $this->builderFromConditions($conditions)->delete();
    }

    /**
     * Preps a Builder with "where" conditions.
     *
     * @param Condition[] $conditions
     */
    private function builderFromConditions(array $conditions): BaseBuilder
    {
        $builder = clone $this->builder;

        foreach ($conditions as $condition) {
            switch ($operator = $condition->getOperator()) {
                case 'in':
                    $builder->whereIn($condition->getField(), $condition->getValue());
                    break;

                case '!in':
                    $builder->whereNotIn($condition->getField(), $condition->getValue());
                    break;

                default:
                    $builder->where($condition->getField() . ' ' . $condition->getOperator(), $condition->getValue());
            }
        }

        return $builder;
    }
}
