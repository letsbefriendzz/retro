<?php

namespace Database\Factories;

use App\Models\Column;
use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;

class ColumnFactory extends Factory
{
    protected $model = Column::class;

    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'session_id' => Session::factory(),
        ];
    }
}
