<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterEndpointCreatesANewUser()
    {
        $data = factory(User::class)->raw();

        $this->postJson('/auth/register', $data)->assertCreated();

        $this->assertTrue(User::whereEmail($data['email'])->exists());
    }

    public function testSuccessFullRegistrationAuthenticatesTheUserAutomatically()
    {
        $data = factory(User::class)->raw();

        $this->postJson('/auth/register', $data)->assertCreated();

        $this->assertEquals(Auth::user()->email, $data['email']);
    }

    public function testRegistrationFailsWithInvalidEmailAddress()
    {
        $data = factory(User::class)->raw(['email' => 'wrong-email-address']);

        $this->postJson('/auth/register', $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email' => 'The email must be a valid email address.']);
    }

    public function testRegistrationWithExistingEmailsFailsValidation()
    {
        $existingUser = factory(User::Class)->create();

        $data = factory(User::class)->raw(['email' => $existingUser->email]);

        $this->postJson('/auth/register', $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email' => 'The email has already been taken.']);
    }

    public function testItHashesTheUserPasswordBeforePersistingIt()
    {
        $data = factory(User::class)->raw(['password' => 'secret']);

        $this->postJson('/auth/register', $data)->assertCreated();

        $this->assertTrue(
            Hash::check('secret', User::whereEmail($data['email'])->value('password'))
        );
    }
}
