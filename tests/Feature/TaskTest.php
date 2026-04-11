<?php

use App\Models\Task;

test('can view tasks index', function () {
    $response = $this->get(route('tasks.index'));

    $response->assertStatus(200);
});

test('can view create task page', function () {
    $response = $this->get(route('tasks.create'));

    $response->assertStatus(200);
});

test('can create a task', function () {
    $response = $this->post(route('tasks.store'), [
        'title' => 'Test Task',
        'description' => 'Test Description',
    ]);

    $response->assertRedirect(route('tasks.index'));

    $this->assertDatabaseHas('tasks', [
        'title' => 'Test Task',
        'description' => 'Test Description',
    ]);
});

test('can view edit task page', function () {
    $task = Task::factory()->create();

    $response = $this->get(route('tasks.edit', $task));

    $response->assertStatus(200);
    $response->assertSee($task->title);
});

test('can update a task', function () {
    $task = Task::factory()->create();

    $response = $this->put(route('tasks.update', $task), [
        'title' => 'Updated Title',
        'description' => 'Updated Description',
        'completed' => true,
    ]);

    $response->assertRedirect(route('tasks.index'));

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'title' => 'Updated Title',
        'description' => 'Updated Description',
        'completed' => true,
    ]);
});

test('can delete a task', function () {
    $task = Task::factory()->create();

    $response = $this->delete(route('tasks.destroy', $task));

    $response->assertRedirect(route('tasks.index'));

    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
    ]);
});

test('can toggle task completion', function () {
    $task = Task::factory()->create(['completed' => false]);

    $response = $this->patch(route('tasks.toggle', $task));

    $response->assertRedirect(route('tasks.index'));

    $task->refresh();
    expect($task->completed)->toBeTrue();

    $response = $this->patch(route('tasks.toggle', $task));

    $task->refresh();
    expect($task->completed)->toBeFalse();
});

test('task title is required', function () {
    $response = $this->post(route('tasks.store'), [
        'title' => '',
    ]);

    $response->assertSessionHasErrors('title');
});

test('task title cannot exceed 255 characters', function () {
    $response = $this->post(route('tasks.store'), [
        'title' => str_repeat('a', 256),
    ]);

    $response->assertSessionHasErrors('title');
});
