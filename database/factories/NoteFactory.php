<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->words(5, true),
        ];
    }
}
