<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;

class LoginController extends AccessTokenController
{

    public function newLogin(ServerRequestInterface $request, $guard)
    {
        $request = $request->withParsedBody(array_merge(
            config('ch.auth'),
            $request->getParsedBody()
        ));

        $tokenResponse =  parent::issueToken($request);
        if ($tokenResponse->getStatusCode() === 200) {
            $response['token_data'] = json_decode($tokenResponse->getContent(), true);
            $model = $this->getModel($guard);
            $response['user'] = $model::where('email', request('username'))->first();

            return response()->json($response, 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    private function getModel($guard)
    {
        $model =  'App\Models\\' . ucfirst($guard);
        return class_exists($model) ? $model : null;
    }

    private function getProvider($guard)
    {
        return @config('auth.guards')[$guard]['provider'];
    }

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
        if($guard == "admin"){
            if (!$token = Auth::guard("{$guard}-api")->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            $user = Auth::guard("{$guard}-api")->user();
            if($user->active = 0){
                return response()->json([
                    'Message' => 'your account has been disabled'
                ]);
            }
            return response()->json([
                'token' => $this->getArrayToken($token),
                'user' => $user,
            ], 200);
        }
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

