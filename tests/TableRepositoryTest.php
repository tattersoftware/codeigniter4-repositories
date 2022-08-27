<?php

declare(strict_types=1);

namespace Tests;

use CodeIgniter\Events\Events;
use Tatter\Repositories\Condition;
use Tatter\Repositories\Repositories\TableRepository;
use Tests\Support\DatabaseTestCase;
use Tests\Support\Models\PlayerModel;
use Tests\Support\Repositories\Player;
use Tests\Support\Repositories\PlayerRepository;
use Traversable;

/**
 * @internal
 */
final class TableRepositoryTest extends DatabaseTestCase
{
    private PlayerRepository $players;
    
    protected function setUp(): void
    {
        parent::setUp();

        $this->players = new PlayerRepository();
    }

    public function testRequiresTableConstant(): void
    {
        $this->expectException('UnexpectedValueException');
        $this->expectExceptionMessage('TABLE class constant must be set!');

        new class () extends TableRepository {
        };
    }

    public function testRequiresEntityConstant(): void
    {
        $this->expectException('UnexpectedValueException');
        $this->expectExceptionMessage('ENTITY class constant must be set!');

        new class () extends TableRepository {
            public const TABLE = 'bananas';
        };
    }

    public function testConstructorCallsInitialize(): void
    {
        $called = false;

        Events::on('playerRepositoryInitialized', static function () use (&$called) {
            $called = true;
        });

        new PlayerRepository();
        $this->assertTrue($called);
    }

    public function testGetsPlayer(): void
    {
        $row = fake(PlayerModel::class);

        $result = $this->players->get($row['id']);
        
        $this->assertInstanceOf(Player::class, $result);
        $this->assertSame($row['id'], $result->getId());
        $this->assertSame($row['name'], $result->name);
    }

    public function testGetsNull(): void
    {
        $result = $this->players->get(42);

        $this->assertNull($result);
    }

    public function testRemovesPlayer(): void
    {
        $row    = fake(PlayerModel::class);
        $player = Player::fromArray($row);

        $this->players->remove($player);

        $this->dontSeeInDatabase('players', ['id' => $row['id']]);
    }

    public function testRemoveIgnoresWithoutId(): void
    {
        $player = Player::fromArray([
            'name' => 'Broseph',
        ]);

        $this->players->remove($player);

        $this->dontSeeInDatabase('players', ['name' => 'Broseph']);
    }

    public function testSavesInsertsNew(): void
    {
        $player = Player::fromArray([
            'name'     => 'The Catalizer',
            'position' => 'Couch',
        ]);

        $this->players->save($player);

        $this->seeInDatabase('players', ['position' => 'Couch']);
    }

    public function testSavesUPdatesExisting(): void
    {
        $row    = fake(PlayerModel::class);
        $player = Player::fromArray($row);
        $player->position = 'Midlane';

        $this->players->save($player);

        $this->seeInDatabase('players', ['position' => 'Midlane']);
    }

    public function testLists(): void
    {
        for ($i = 0; $i < 2; $i++) {
            fake(PlayerModel::class, [
                'position' => 'Roaming',
            ]);
        }
        $condition = Condition::fromString('position = Roaming');

        $result = $this->players->list([$condition]);
        $this->assertInstanceOf(Traversable::class, $result);
        
        $players = iterator_to_array($result);
        $this->assertCount(2, $players);
    }
}
