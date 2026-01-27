<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Hole bestehende User oder erstelle neue
        $users = User::all();
        
        if ($users->isEmpty()) {
            $users = User::factory(5)->create();
        }

        // Erstelle 10 Projekte
        Project::factory(10)->create([
            'owner_id' => $users->random()->id,
        ]);
    }
}
