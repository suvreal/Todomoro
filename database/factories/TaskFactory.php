<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->words(5, true)),
            'summary' => $this->faker->sentence(4, true),
            'note' => $this->faker->paragraph(1),
            'parent_task_id' => null,
            'status' => $this->faker->randomElement(['todo', 'wip', 'done']),
            'deadline_datetime' => $this->faker->optional()->dateTimeBetween('now', '+30 days'),
        ];
    }
}
