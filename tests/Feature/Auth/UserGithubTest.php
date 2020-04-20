<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use App\Services\GitHub\Contracts\GithubApi;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserGithubTest extends TestCase
{
    use RefreshDatabase;

    public function testGithubMethodThrowsAnExceptionIfNotokenIsSet()
    {
        $user = factory(User::Class)->create(['github_token' => null]);

        $this->expectException(\App\Exceptions\MissingGithubTokenException::class);

        $user->github();
    }

    public function testItReturnsTheUserSharedRepos()
    {
        $user = factory(User::Class)->create(['github_token' => 'some-token']);

        $this->mock(GithubApi::class, function ($mock) {
            $mock->shouldReceive('authenticateUsingToken');

            $mock
                ->shouldReceive('getUserStarredRepositories')
                ->once()
                ->andReturn([1, 3, 4]);
        });

        $this->assertEquals($user->github()->getUserStarredRepositories(), [1, 3, 4]);
    }
}
