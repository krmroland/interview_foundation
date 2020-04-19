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
            ->postJson('/auth/updateGithubToken', ['github_token' => 'some-token'])
            ->assertStatus(200);

        $this->assertEquals($user->fresh()->github_token, 'some-token');
    }

    public function testUpdateTokenAllowsNullValues()
    {
        $user = factory(User::class)->create(['github_token' => Str::random(6)]);

        $this->actingAs($user)
            ->postJson('/auth/updateGithubToken', ['github_token' => null])
            ->assertStatus(200);

        $this->assertNull($user->fresh()->github_token);
    }
}
