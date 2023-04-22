<?php

namespace Tests\Feature\Controllers;

use App\Models\Session;
use App\Models\User;
use Tests\TestCase;
use function PHPUnit\Framework\assertCount;

class SessionControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

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

    public function test_it_creates_default_columns_for_sessions()
    {
        $this->get('/snickers')
            ->assertSuccessful();

        $this->assertCount(
            3,
            Session::query()->where('slug', '=', 'snickers')->first()->columns
        );
    }
}
