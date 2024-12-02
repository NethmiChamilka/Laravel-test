<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Task;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_task()
    {

        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')->postJson('/api/tasks', [
            'title' => 'Test Task',
            'description' => 'This is a test task',
        ]);

        $response->assertStatus(201)
        ->assertJson([
            'status' => 'success',
            'message' => 'Task created successfully',
        ]);
    }
}
