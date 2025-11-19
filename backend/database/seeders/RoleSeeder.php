<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Insérer les rôles dans la table "roles"
        DB::table('roles')->insert([
            ['role' => 'admin'],
            ['role' => 'user'],
            ['role' => 'subscriber'],
        ]);
    }
}