<?php

namespace Tests\Feature\Controllers;

use App\Models\RetroSession;
use Tests\TestCase;

class RetroSessionControllerTest extends TestCase
{
    public function test_it_can_create_a_retro_session()
    {
        $this->get('/snickers')
            ->assertSuccessful();

        $this->assertDatabaseHas('retro_sessions', ['slug' => 'snickers']);
    }

    public function test_it_gets_previously_existing_retro_session()
    {
        $this->get('/snickers')
            ->assertSuccessful();

        $this->assertDatabaseHas('retro_sessions', ['slug' => 'snickers']);

        $this->get('/snickers')
            ->assertSuccessful();
    }
}
