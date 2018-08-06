<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function hospitalLogin(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::guard('hospital')->attempt($credentials)) {
            $user = Auth::guard('hospital')->user();
            $token = $user->createToken(config('app.name'))->accessToken;
            return response()->json(['user' => $user, 'access_token' => $token], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
