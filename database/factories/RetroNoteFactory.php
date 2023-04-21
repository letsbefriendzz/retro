<?php

namespace Database\Factories;

use App\Models\RetroNote;
use App\Models\RetroSession;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
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
//            'retro_session_id' => RetroSession::factory(),
            'retro_column' => 'wentWell',
            'content' => $this->faker->words(5, true),
        ];
    }
}
