<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Task::class;
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'status' => $this->faker->randomElement(['pending', 'in-progress', 'completed']),
            'user_id' => User::factory(),
        ];
    }
}
