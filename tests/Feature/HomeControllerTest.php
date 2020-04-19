<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAccessingHomeControllerRedirectsUnAuthenticatedUsersToAuthPage()
    {
        $this->get('/')->assertRedirect('auth');
    }

    public function testItReturnsA401ResponseStatusCodeWithNoRedirectForJsonRequests()
    {
        $this->getJson('/')->assertStatus(401);
    }

    public function testItRendersTheHomePageIfUserIsAuthenticated()
    {
        $this->actingAs(factory(User::class)->create())
            ->get('/')
            ->assertOk();
    }
}
