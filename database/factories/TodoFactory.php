<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Todo;
use App\Models\User;        // ← ここを追加

class TodoFactory extends Factory
{
    protected $model = Todo::class;

    public function definition(): array
    {
        return [
            'title'       => $this->faker->sentence(3),
            'description' => $this->faker->optional()->text(100),
            'due_date'    => $this->faker->optional()->date(),
            'status'      => $this->faker->randomElement(['pending', 'done']),
            // User ファクトリを正しく参照
            'user_id'     => User::factory(),
        ];
    }
}
