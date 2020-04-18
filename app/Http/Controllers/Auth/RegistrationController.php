<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;

class RegistrationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            "name" => "required",
            "email" => "required|unique:users",
            "password" => "required|min:6",
        ]);

        $user = User::create($data);

        event(new Registered($user));

        return response()->json(
            ["message" => "User was created successfully", "user" => $user],
            201
        );
    }
}
