<?php

declare(strict_types=1);

namespace Tests\Support\Models;

use CodeIgniter\Model;
use Faker\Generator;

class PlayerModel extends Model
{
    protected $table           = 'players';
    protected $returnType      = 'array';
    protected $useSoftDeletes  = true;
    protected $allowedFields   = ['name', 'position'];
    protected $useTimestamps   = true;
    protected $validationRules = [
        'name'     => 'required|string|max_length[255]',
        'position' => 'permit_empty|string',
    ];

    /**
     * Faked data for Fabricator.
     */
    public function fake(Generator &$faker): array
    {
        return [
            'name'     => $faker->name,
            'position' => '',
        ];
    }
}
