<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request, $guard)
    {
        $credentials = $request->only(['email', 'password']);
        if (Auth::guard($guard)->attempt($credentials)) {
            $user = Auth::guard($guard)->user();
            $token = $user->createToken(config('app.name'))->accessToken;
            return response()->json(['user' => $user, 'access_token' => $token], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
