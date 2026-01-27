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
        // Erstelle einen Test-Admin-User
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@teamhub.test',
            'password' => bcrypt('password'),
        ]);

        // Erstelle weitere Test-User
        \App\Models\User::factory(9)->create();

        // Seede Projekte und Tasks
        $this->call([
            ProjectSeeder::class,
            TaskSeeder::class,
        ]);
    }
}
