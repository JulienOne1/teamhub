<?php

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->token = $this->user->createToken('test')->plainTextToken;
    $this->project = Project::factory()->create(['owner_id' => $this->user->id]);
});

test('unauthenticated user cannot access tasks', function () {
    $response = $this->getJson('/api/tasks');

    $response->assertStatus(401);
});

test('authenticated user can get all tasks', function () {
    Task::factory(5)->create([
        'project_id' => $this->project->id,
        'created_by' => $this->user->id,
    ]);

    $response = $this->withHeaders([
        'Authorization' => "Bearer {$this->token}",
    ])->getJson('/api/tasks');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                '*' => ['id', 'title', 'priority', 'status', 'project'],
            ],
        ]);

    expect($response->json('data'))->toHaveCount(5);
});

test('authenticated user can create task', function () {
    $response = $this->withHeaders([
        'Authorization' => "Bearer {$this->token}",
    ])->postJson('/api/tasks', [
        'title' => 'New Test Task',
        'description' => 'Task description',
        'project_id' => $this->project->id,
        'assigned_to' => $this->user->id,
        'created_by' => $this->user->id,
        'priority' => 'high',
        'status' => 'todo',
        'due_date' => '2026-03-01',
    ]);

    $response->assertStatus(201)
        ->assertJsonPath('data.title', 'New Test Task')
        ->assertJsonPath('data.priority', 'high');

    expect(Task::where('title', 'New Test Task')->exists())->toBeTrue();
});

test('authenticated user cannot create task with invalid data', function () {
    $response = $this->withHeaders([
        'Authorization' => "Bearer {$this->token}",
    ])->postJson('/api/tasks', [
        'title' => '',
        'priority' => 'invalid',
        'status' => 'invalid',
    ]);

    $response->assertStatus(422);
});

test('authenticated user can get single task', function () {
    $task = Task::factory()->create([
        'project_id' => $this->project->id,
        'created_by' => $this->user->id,
    ]);

    $response = $this->withHeaders([
        'Authorization' => "Bearer {$this->token}",
    ])->getJson("/api/tasks/{$task->id}");

    $response->assertStatus(200)
        ->assertJsonPath('data.id', $task->id)
        ->assertJsonPath('data.title', $task->title);
});

test('authenticated user can update task', function () {
    $task = Task::factory()->create([
        'project_id' => $this->project->id,
        'created_by' => $this->user->id,
    ]);

    $response = $this->withHeaders([
        'Authorization' => "Bearer {$this->token}",
    ])->putJson("/api/tasks/{$task->id}", [
        'title' => 'Updated Task Title',
        'priority' => 'urgent',
        'status' => 'in_progress',
    ]);

    $response->assertStatus(200)
        ->assertJsonPath('data.title', 'Updated Task Title')
        ->assertJsonPath('data.priority', 'urgent');

    $task->refresh();
    expect($task->title)->toBe('Updated Task Title');
});

test('authenticated user can delete task', function () {
    $task = Task::factory()->create([
        'project_id' => $this->project->id,
        'created_by' => $this->user->id,
    ]);

    $response = $this->withHeaders([
        'Authorization' => "Bearer {$this->token}",
    ])->deleteJson("/api/tasks/{$task->id}");

    $response->assertStatus(200)
        ->assertJsonPath('success', true);

    expect(Task::where('id', $task->id)->exists())->toBeFalse();
});

test('authenticated user can update task status', function () {
    $task = Task::factory()->create([
        'project_id' => $this->project->id,
        'created_by' => $this->user->id,
        'status' => 'todo',
    ]);

    $response = $this->withHeaders([
        'Authorization' => "Bearer {$this->token}",
    ])->putJson("/api/tasks/{$task->id}", [
        'status' => 'done',
    ]);

    $response->assertStatus(200)
        ->assertJsonPath('data.status', 'done');
});