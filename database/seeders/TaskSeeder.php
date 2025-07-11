<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        if (Task::count() === 0) {
            $this->performSeed();
            $this->command->info('Tasks seeded.');
        } else {
            $this->command->info('Tasks already exist. Seeder skipped.');
        }
    }

    private function performSeed(): void
    {
        Task::create(
            [
                'title' => 'Welcome Task',
                'summary' => 'This is your first task.',
                'note' => 'You can edit or delete this task as needed.',
                'status' => 'todo',
                'deadline_datetime' => now()->addDays(7),
            ]
        );

        Task::create(
            [
                'title' => 'Second Example Task',
                'summary' => '',
                'note' => 'Do something.',
                'status' => 'wip',
                'deadline_datetime' => now()->addDays(14),
            ]
        );

        Task::create(
            [
                'title' => 'Third Example Task',
                'summary' => 'Some task about anything.',
                'note' => 'Try changing its status or deadline.',
                'status' => 'done',
                'deadline_datetime' => now()->addDays(14),
            ]
        );

        Task::factory()->count(10)->create();
    }
}
