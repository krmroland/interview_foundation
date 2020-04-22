<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Tests\Feature\MocksGithubApiClient;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetGithubStarredReposControllerTest extends TestCase
{
    use MocksGithubApiClient, RefreshDatabase;

    public function testAPiReturnsStarredRepostioriesForCurrentlyAuthenticatedUser()
    {
        $this->addMockHttpResponse(json_encode([]));

        $this->actingAs(factory(User::class)->create(['github_token' => 'some-token']))
            ->getJson('/auth/starredGithubRepositories')
            ->assertOk();
    }

    public function testItReturnsA401IfUserDoesntHaveAGitHubToken()
    {
        $this->addMockHttpResponse(json_encode([]));

        $this->actingAs(factory(User::class)->create())
            ->getJson('/auth/starredGithubRepositories')
            ->assertStatus(400)
            ->assertJson(['error' => 'Missing  git-hub token']);
    }
}
