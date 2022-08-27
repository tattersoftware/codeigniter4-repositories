<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\Repositories\Player;
use Tests\Support\TestCase;

/**
 * @internal
 */
final class EntityTest extends TestCase
{
    public function testGetWithoutKeyReturnsNull(): void
    {
        $player = Player::fromArray(['name' => 'Lupe Fiasco']);

        $this->assertNull($player->id);
    }

    public function testGetUnknownKeyThrows(): void
    {
        $player = Player::fromArray(['name' => 'Lupe Fiasco']);

        $this->expectException('OutOfBoundsException');
        $this->expectExceptionMessage('Undefined property: ' . Player::class . '::banana');

        $player->banana; // @phpstan-ignore-line
    }

    public function testUnsetsValue(): void
    {
        $player = Player::fromArray([
            'name'  => 'HtotheUskyHusky',
            'power' => 1,
        ]);
        $this->assertSame(1, $player->power);

        unset($player->power);

        $this->expectException('OutOfBoundsException');
        $this->expectExceptionMessage('Undefined property: ' . Player::class . '::power');

        $player->power; // @phpstan-ignore-line
    }
}
