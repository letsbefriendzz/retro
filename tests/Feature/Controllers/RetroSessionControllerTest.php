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
}
