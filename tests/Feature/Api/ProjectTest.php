<?php

use App\Models\Project;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->token = $this->user->createToken('test')->plainTextToken;
});

test('unauthenticated user cannot access projects', function () {
    $response = $this->getJson('/api/projects');

    $response->assertStatus(401);
});

test('authenticated user can get all projects', function () {
    Project::factory(5)->create(['owner_id' => $this->user->id]);

    $response = $this->withHeaders([
        'Authorization' => "Bearer {$this->token}",
    ])->getJson('/api/projects');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                '*' => ['id', 'name', 'description', 'status', 'owner'],
            ],
        ]);

    expect($response->json('data'))->toHaveCount(5);
});

test('authenticated user can create project', function () {
    $response = $this->withHeaders([
        'Authorization' => "Bearer {$this->token}",
    ])->postJson('/api/projects', [
        'name' => 'Test Project',
        'description' => 'A test project',
        'start_date' => '2026-01-01',
        'end_date' => '2026-06-01',
        'status' => 'planning',
        'owner_id' => $this->user->id,
    ]);

    $response->assertStatus(201)
        ->assertJsonPath('data.name', 'Test Project')
        ->assertJsonPath('data.status', 'planning');

    expect(Project::where('name', 'Test Project')->exists())->toBeTrue();
});

test('authenticated user cannot create project with invalid data', function () {
    $response = $this->withHeaders([
        'Authorization' => "Bearer {$this->token}",
    ])->postJson('/api/projects', [
        'name' => '',
        'status' => 'invalid_status',
    ]);

    $response->assertStatus(422);
});

test('authenticated user can get single project', function () {
    $project = Project::factory()->create(['owner_id' => $this->user->id]);

    $response = $this->withHeaders([
        'Authorization' => "Bearer {$this->token}",
    ])->getJson("/api/projects/{$project->id}");

    $response->assertStatus(200)
        ->assertJsonPath('data.id', $project->id)
        ->assertJsonPath('data.name', $project->name);
});

test('authenticated user can update project', function () {
    $project = Project::factory()->create(['owner_id' => $this->user->id]);

    $response = $this->withHeaders([
        'Authorization' => "Bearer {$this->token}",
    ])->putJson("/api/projects/{$project->id}", [
        'name' => 'Updated Project Name',
        'status' => 'active',
    ]);

    $response->assertStatus(200)
        ->assertJsonPath('data.name', 'Updated Project Name')
        ->assertJsonPath('data.status', 'active');

    $project->refresh();
    expect($project->name)->toBe('Updated Project Name');
});

test('authenticated user can delete project', function () {
    $project = Project::factory()->create(['owner_id' => $this->user->id]);

    $response = $this->withHeaders([
        'Authorization' => "Bearer {$this->token}",
    ])->deleteJson("/api/projects/{$project->id}");

    $response->assertStatus(200)
        ->assertJsonPath('success', true);

    expect(Project::where('id', $project->id)->exists())->toBeFalse();
});

test('authenticated user can get project tasks', function () {
    $project = Project::factory()->create(['owner_id' => $this->user->id]);
    $project->tasks()->create([
        'title' => 'Test Task',
        'created_by' => $this->user->id,
        'priority' => 'medium',
        'status' => 'todo',
    ]);

    $response = $this->withHeaders([
        'Authorization' => "Bearer {$this->token}",
    ])->getJson("/api/projects/{$project->id}/tasks");

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                '*' => ['id', 'title', 'priority', 'status'],
            ],
        ]);
});