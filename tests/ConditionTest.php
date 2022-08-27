<?php

declare(strict_types=1);

namespace Tests;

use Tatter\Repositories\Condition;
use Tests\Support\TestCase;

/**
 * @internal
 */
final class ConditionTest extends TestCase
{
    public function testFromStringRequiresAtLeastThreeSegments(): void
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Invalid condition string: foo in');

        Condition::fromString('foo in');
    }

    public function testConstructorInvalidOperatorThrows(): void
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Unknown conditional operation: <>');

        new Condition('fruit', '<>', 'banana');
    }

    public function testConstructorForbidsArray(): void
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Invalid array operator: =');

        new Condition('fruit', '=', []);
    }

    public function testConstructorRequiresArray(): void
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Missing array for operator: in');

        new Condition('fruit', 'in', 'banana');
    }
}
