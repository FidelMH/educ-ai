<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // 1. D'ABORD créer les rôles
        $this->call([
            RoleSeeder::class,
        ]);

        // 2. ENSUITE créer l'admin
        User::factory()->create([
            'firstname' => 'Admin',
            'lastname'  => 'Super',
            'email'     => 'admin@example.com',
            'email_verified_at' => now(),
            'password'  => bcrypt('password'),
            'consentement' => 1,
            'roles_id'  => 1, // admin
        ]);
    }
}
