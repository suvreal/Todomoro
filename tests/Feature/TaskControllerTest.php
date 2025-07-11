<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_the_tasks_index_page()
    {
        Task::factory()->create(['title' => 'Test Task']);

        $response = $this->get('/tasks');

        $response->assertStatus(200);
        $response->assertSee('Test Task');
    }

    /** @test */
    public function it_filters_tasks_by_search()
    {
        Task::factory()->create(['title' => 'Unique Task']);
        Task::factory()->create(['title' => 'Another Task']);

        $response = $this->get('/tasks?search=Unique');

        $response->assertStatus(200);
        $response->assertSee('Unique Task');
        $response->assertDontSee('Another Task');
    }

    /** @test */
    public function it_can_store_a_task()
    {
        $response = $this->post('/tasks', [
            'title' => 'New Task',
            'status' => 'todo',
        ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('task', ['title' => 'New Task']);
    }

    /** @test */
    public function it_can_show_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->get("/tasks/{$task->id}");

        $response->assertStatus(200);
        $response->assertSee($task->title);
    }

    /** @test */
    public function it_can_edit_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->get("/tasks/{$task->id}/edit");

        $response->assertStatus(200);
        $response->assertSee($task->title);
    }

    /** @test */
    public function it_can_update_a_task()
    {
        $task = Task::factory()->create([
            'title' => 'Old Title',
            'status' => 'todo',
        ]);

        $response = $this->put("/tasks/{$task->id}", [
            'title' => 'Updated Title',
            'status' => 'wip',
        ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('task', ['title' => 'Updated Title']);
    }

    /** @test */
    public function it_can_delete_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->delete("/tasks/{$task->id}");

        $response->assertRedirect('/tasks');
        $this->assertDatabaseMissing('task', ['id' => $task->id]);
    }
}
