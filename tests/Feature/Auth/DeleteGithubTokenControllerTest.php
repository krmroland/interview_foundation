<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteGithubTokenControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testItUpdatesTheUsersGithubTokenSuccessfully()
    {
        $user = factory(User::class)->create(['github_token' => 'some-token']);

        $this->actingAs($user)
            ->deleteJson('/auth/githubToken')
            ->assertStatus(204);

        $this->assertNull($user->fresh()->github_token);
    }
}
