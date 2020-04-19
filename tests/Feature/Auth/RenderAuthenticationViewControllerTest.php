<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RenderAuthenticationViewControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testItRedirectsAuthenticatedUsersToTheHomePage()
    {
        $this->actingAs(factory(User::class)->create())
            ->get('/auth')
            ->assertRedirect('/');
    }

    public function testItRedirectsTheAuthViewForUnAuthenticatedUsers()
    {
        $this->get('/auth')
            ->assertOk()
            ->assertViewIs('auth.index');
    }
}
