<?php

declare(strict_types=1);

namespace Tests\Support\Repositories;

use CodeIgniter\Events\Events;
use Tatter\Repositories\Repositories\TableRepository;

/**
 * @extends TableRepository<Player>
 * @internal
 */
final class PlayerRepository extends TableRepository
{
    public const TABLE  = 'players';
    public const ENTITY = Player::class;

    public function initialize(): void
    {
        Events::trigger('playerRepositoryInitialized');
    }
}
