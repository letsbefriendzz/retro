<?php

namespace Tests\Feature\Controllers;

use App\Models\Session;
use Tests\TestCase;

class SessionControllerTest extends TestCase
{
    public function test_it_can_create_a_session()
    {
        $this->get('/snickers')
            ->assertSuccessful();

        $this->assertDatabaseHas('sessions', ['slug' => 'snickers']);
    }

    public function test_it_gets_previously_existing_session()
    {
        $this->get('/snickers')
            ->assertSuccessful();

        $this->assertDatabaseHas('sessions', ['slug' => 'snickers']);

        $this->get('/snickers') // todo test harder
            ->assertSuccessful();
    }
}
