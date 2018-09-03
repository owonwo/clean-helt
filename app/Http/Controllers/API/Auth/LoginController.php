<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request, $guard)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::guard($guard)->attempt($credentials)) {
            $user = auth()->guard($guard)->user();

            $token = $user->createToken(config('app.name'))->accessToken;

            return response()->json([
                'user' => $user,
                'access_token' => $token,
                'expires_in' => $this->getTokenExpiration()
            ], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function logout($guard){

        auth()->guard($guard)->logout();

        return redirect('/')->response()->json([
            'Message' => 'Logout successful'
        ]);
    }

    // 6 hours in seconds
    private function getTokenExpiration()
    {
        return 6 * 60 * 60;
    }
}
