<?php

declare(strict_types=1);

namespace Tatter\Repositories\Persistence;

use CodeIgniter\Database\BaseBuilder;
use Config\Database;
use Generator;
use RuntimeException;
use Tatter\Repositories\Conditions\Conditions;
use Tatter\Repositories\Objects\DTO;

/**
 * SQL Database Persistence Class
 *
 * A wrapper for the Query Builder to enforce
 * data types at boundaries.
 */
final class SQLDatabase
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
     */
    public function first(Conditions $conditions): ?DTO
    {
        $result = $this->builderFromConditions($conditions)
            ->limit(1)
            ->get();
        if ($result === false) {
            throw new RuntimeException('Query Builder result failed.');
        }

        return $result->getFirstRow(DTO::class);
    }

    /**
     * Gets an item from persistence by its ID.
     *
     * @returns iterable<DTO>
     */
    public function get(Conditions $conditions): Generator
    {
        $result = $this->builderFromConditions($conditions)->get();
        if ($result === false) {
            throw new RuntimeException('Query Builder result failed.');
        }

        while ($dto = $result->getUnbufferedRow(DTO::class)) {
            yield $dto;
        }
    }

    /**
     * Inserts a new row into the database.
     */
    public function insert(DTO $dto): void
    {
        (clone $this->builder)->insert($dto->toArray());
    }

    /**
     * Updates rows in the database.
     */
    public function update(Conditions $conditions, DTO $dto): void
    {
        $this->builderFromConditions($conditions)->update($dto->toArray());
    }

    /**
     * Deletes matching items from the database.
     */
    public function delete(Conditions $conditions): void
    {
        $this->builderFromConditions($conditions)->delete();
    }

    /**
     * Preps a Builder with "where" conditions.
     */
    private function builderFromConditions(Conditions $conditions): BaseBuilder
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
