<?php

namespace Database\Factories;

use App\Models\RetroSession;
use App\Models\RetroUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RetroUser>
 */
class RetroUserFactory extends Factory
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
            'name' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'colour' => $this->faker->randomElement(RetroUser::DAISY_UI_COLOURS),
        ];
    }
}
