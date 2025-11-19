<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Level::create([
            'level' => '6ème',
            'description' => 'Première année du collège',
        ]);

        Level::create([
            'level' => '5ème',
            'description' => 'Deuxième année du collège',
        ]);

        Level::create([
            'level' => '4ème',
            'description' => 'Troisième année du collège',
        ]);

        Level::create([
            'level' => '3ème',
            'description' => 'Quatrième année du collège',
        ]);

        Level::create([
            'level' => 'Seconde',
            'description' => 'Première année du lycée',
        ]);

        Level::create([
            'level' => 'Première',
            'description' => 'Deuxième année du lycée',
        ]);

        Level::create([
            'level' => 'Terminale',
            'description' => 'Dernière année du lycée',
        ]);
    }
}
