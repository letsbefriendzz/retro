<?php

namespace Tests\Feature\Controllers;

use App\Models\RetroSession;
use App\Models\RetroUser;
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

    public function test_it_selects_a_colour_that_isnt_used()
    {
        $this->get('/snickers')
            ->assertSuccessful();

        $this->assertDatabaseHas('retro_sessions', ['slug' => 'snickers']);

        $retroSession = RetroSession::query()->where('slug', 'snickers')->first();

        $this->assertDatabaseHas('retro_users', [
            'retro_session_id' => $retroSession->id,
        ]);

        $this->assertNotNull($retroSession->retroUsers()->first()->colour);
    }

    public function test_colour_is_set_to_null_when_all_colours_are_taken()
    {
        $daisyUiColours = collect(RetroUser::DAISY_UI_COLOURS);
        $daisyUiColours->each(fn() => $this->get('/snickers')->assertSuccessful());

        $this->assertDatabaseCount('retro_users', $daisyUiColours->count());

        $retroSession = RetroSession::query()->where('slug', 'snickers')->first();

        $this->get('/snickers')->assertSuccessful();

        $this->assertEquals('base-100', $retroSession->retroUsers->last()->colour);
    }
}
