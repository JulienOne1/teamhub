<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $projects = Project::all();
        $users = User::all();

        // Erstelle 3-7 Tasks pro Projekt
        foreach ($projects as $project) {
            $taskCount = rand(3, 7);
            
            Task::factory($taskCount)->create([
                'project_id' => $project->id,
                'assigned_to' => $users->random()->id,
                'created_by' => $project->owner_id, // Projekt-Owner erstellt die Tasks
            ]);
        }
    }
}
