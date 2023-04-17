<?php

namespace Database\Factories;

use App\Models\RetroNote;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RetroNote>
 */
class RetroNoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'retro_column' => 'wentWell',
            'content' => $this->faker->words(5, true),
        ];
    }
}
