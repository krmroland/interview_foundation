<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginWithValidCredentialsAuthenticatesUser()
    {
        $user = factory(User::class)->create(['password' => 'password']);

        $this->postJson('/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertOk();

        $this->assertAuthenticatedAs($user);
    }

    public function testLoginWithInValidCredentialsFails()
    {
        $user = factory(User::class)->make(['password' => 'password']);

        $this->postJson('/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email' => trans('auth.failed')]);

        $this->assertGuest();
    }

    public function testLoginRedirectsToHomeIfUserIsAlreadyAuthenticated()
    {
        $this->actingAs(factory(User::class)->create());

        $this->postJson('/auth/login', [
            'email' => 'email@example.com',
            'password' => 'password',
        ])->assertRedirect('/');
    }
}
