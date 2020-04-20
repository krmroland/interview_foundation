<?php

namespace Tests\Feature\Auth;

use App\User;
use Github\Client;
use Tests\TestCase;

use Tests\Feature\MocksGithubApiClient;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserGithubTest extends TestCase
{
    use RefreshDatabase, MocksGithubApiClient;

    public function testGithubMethodThrowsAnExceptionIfNotokenIsSet()
    {
        $user = factory(User::class)->create(['github_token' => null]);

        $this->expectException(\App\Exceptions\MissingGithubTokenException::class);

        $user->github();
    }

    public function testItReturnsTheUserSharedRepos()
    {
        $user = factory(User::class)->create(['github_token' => 'some-token']);

        $response = json_encode([1, 2, 34]);

        $this->addMockHttpResponse($response);

        $this->assertSame($user->github()->getUserStarredRepositories(), $response);
    }
}
