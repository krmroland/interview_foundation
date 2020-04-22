<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testItEncryptsTheUserGithubToken()
    {
        $user = factory(User::class)->create(['github_token' => Str::random('5')]);

        $this->assertNotNull($user->github_token);

        $this->assertSame($user->github_token, decrypt($user->getRawOriginal('github_token')));
    }

    public function testItDoesntEncrpytGithubTokenBlankValues()
    {
        $user = factory(User::class)->create(['github_token' => null]);

        $this->assertNull($user->getRawOriginal('github_token'));
    }

    public function testItReturnsANullTokenIfTheApiKeyChanges()
    {
        $user = factory(User::class)->create(['github_token' => Str::random('5')]);

        $this->assertNotNull($user->github_token);

        $this->app->config->set('app.key', Str::random('32'));

        // we need the container to re resolve the encrypter so we will go ahead and tell
        // the container to forget about it
        $this->app->forgetInstance('encrypter');

        $this->assertNull($user->fresh()->github_token);
    }
}
