<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class RetroSessionControllerTest extends TestCase
{
    public function test_it_can_create_a_retro_session()
    {
        $this->get('/snickers')
            ->assertSuccessful();

        $this->assertDatabaseHas('retro_sessions', ['slug' => 'snickers']);
    }

    public function test_it_creates_a_user_with_a_session()
    {
        $this->get('/snickers')
            ->assertSuccessful();

        $this->assertDatabaseCount('retro_users', 1);
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
