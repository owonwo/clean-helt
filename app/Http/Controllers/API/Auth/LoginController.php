<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class LoginController extends Controller
{






    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }

    public function login(Request $request, $guard)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::guard("{$guard}-api")->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'token' => $this->getArrayToken($token),
            'user' => Auth::guard("{$guard}-api")->user(),
        ], 200);
    }


    /**
     * @param $token
     * @return array
     */
    protected function getArrayToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('doctor-api')->factory()->getTTL() * 60
        ];
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
