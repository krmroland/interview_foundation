<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterEndpointCreatesANewUser()
    {
        $data = factory(User::class)->raw();

        $this->postJson("api/auth/register", $data)->assertCreated();

        $this->assertEquals(User::limit(1)->value("email"), $data["email"]);
    }
}
