<?php

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->token = $this->user->createToken('test')->plainTextToken;
});

test('authenticated user can get all users', function () {
    User::factory(4)->create();

    $response = $this->withHeaders([
        'Authorization' => "Bearer {$this->token}",
    ])->getJson('/api/users');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                '*' => ['id', 'name', 'email'],
            ],
        ]);

    // 4 neue + 1 beforeEach user = 5
    expect($response->json('data'))->toHaveCount(5);
});

test('authenticated user can get single user', function () {
    $otherUser = User::factory()->create();

    $response = $this->withHeaders([
        'Authorization' => "Bearer {$this->token}",
    ])->getJson("/api/users/{$otherUser->id}");

    $response->assertStatus(200)
        ->assertJsonPath('data.id', $otherUser->id)
        ->assertJsonPath('data.name', $otherUser->name);
});

test('user response does not contain password', function () {
    $response = $this->withHeaders([
        'Authorization' => "Bearer {$this->token}",
    ])->getJson("/api/users/{$this->user->id}");

    $response->assertStatus(200);

    expect(array_keys($response->json('data')))->not->toContain('password');
});

test('authenticated user can get user projects', function () {
    Project::factory(3)->create(['owner_id' => $this->user->id]);

    $response = $this->withHeaders([
        'Authorization' => "Bearer {$this->token}",
    ])->getJson("/api/users/{$this->user->id}/projects");

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                '*' => ['id', 'name', 'status'],
            ],
        ]);

    expect($response->json('data'))->toHaveCount(3);
});

test('authenticated user can get user tasks', function () {
    $project = Project::factory()->create(['owner_id' => $this->user->id]);
    Task::factory(4)->create([
        'project_id' => $project->id,
        'assigned_to' => $this->user->id,
        'created_by' => $this->user->id,
    ]);

    $response = $this->withHeaders([
        'Authorization' => "Bearer {$this->token}",
    ])->getJson("/api/users/{$this->user->id}/tasks");

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                '*' => ['id', 'title', 'priority', 'status'],
            ],
        ]);

    expect($response->json('data'))->toHaveCount(4);
});