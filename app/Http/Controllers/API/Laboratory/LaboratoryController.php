<?php

namespace App\Http\Controllers\API\Laboratory;

use App\Models\Laboratory;
use Illuminate\Http\Request;

class LaboratoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:laboratory-api')->except('login');
    }

    public function login(Request $request, $guard)
    {
        $credentials = $request->only(['email', 'password']);
        dd($credentials);
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

    // 6 hours in seconds
    private function getTokenExpiration()
    {
        return 6 * 60 * 60;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Laboratory $laboratory)
    {
        if ($laboratory->update($request->all())) {
            return response()->json([
                'message' => 'Laboratory updated successfully ',
                'labs' => $laboratory
            ], 200);
        }

        return response()->json([
            'message' => 'All data were submitted'
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
