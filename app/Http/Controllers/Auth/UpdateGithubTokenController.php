<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Auth\AuthManager;
use App\Http\Controllers\Controller;

class UpdateGithubTokenController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthManager $auth
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, AuthManager $auth)
    {
        $auth->user()->update($request->validate(['github_token' => 'string']));

        return response()->json([
            'message' => 'Token was updated successfully',
        ]);
    }
}
