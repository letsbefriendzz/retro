<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_redirects_to_provider()
    {
        $mock = Mockery::mock('Laravel\Socialite\Contracts\Factory');
        $mock->shouldReceive('driver')
            ->with('github')
            ->andReturn($mock);
        $mock->shouldReceive('redirect')
            ->andReturn(redirect('https://github.com/login/oauth/authorize'));
        Socialite::swap($mock);

        $response = $this->get(route('login.github'));

        $response->assertRedirect('https://github.com/login/oauth/authorize');
    }
}
