<?php

namespace Tests\Feature\Auth;

use App\User;
use Github\Client;
use Tests\TestCase;
use GuzzleHttp\Psr7\Response;
use Github\HttpClient\Builder;
use Http\Mock\Client as MockClient;
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

        $response = json_encode([1, 2, 34]);

        $this->mockHttpClient($response);

        $this->assertSame($user->github()->getUserStarredRepositories(), $response);
    }

    protected function mockHttpClient($response = null, $status = 200)
    {
        $mock = new MockClient();

        $client = new Client(new Builder($mock));

        if (!is_null($response)) {
            $mock->addResponse(
                new Response($status, ['content-type' => 'Application/json'], $response)
            );
        }

        $this->app->instance(Client::class, $client);

        return $mock;
    }
}
