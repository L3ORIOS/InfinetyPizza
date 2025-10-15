<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario administrador
        User::factory()->admin()->create([
            'name' => 'Admin Infinety',
            'email' => 'admin@infinety.com',
            'password' => bcrypt('password123'),
        ]);

        // Usuario cliente
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Usuario aleatorios
        User::factory(5)->create();
    }
}
