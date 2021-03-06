<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateGithubTokenControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testItUpdatesTheUsersGithubTokenSuccessfully()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->putJson('/auth/githubToken', ['github_token' => 'some-token'])
            ->assertOk();

        $this->assertEquals($user->fresh()->github_token, 'some-token');
    }
}
