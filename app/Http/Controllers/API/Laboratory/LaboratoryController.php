<?php

namespace App\Http\Controllers\API\Laboratory;

use App\Models\Laboratory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaboratoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:laboratory-api')->except('login');

        $this->middleware(function ($request, $next) {
            $this->laboratory = auth()->user();
            return $next($request);
        });
    }

    public function login(Request $request, $guard)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::guard($guard)->attempt($credentials)) {
            $user = auth()->guard($guard)->user();
            $token = $user->createToken(config('app.name'))->accessToken;

            return response()->json([
                'user' => $user,
                'access_token' => $token,
                'expires_in' => $this->getTokenExpiration(),
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
        $laboratory = $this->laboratory;

        return response()->json([
            'message' => 'logged in successfully',
            'laboratory' => $laboratory,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Updates the avatar for the laboratory model
     *
     * @return Json
     **/
    public function updateAvatar()
    {
        $this->validate(request(), ['avatar' => 'image|mimes:jpg,jpeg,png|max:200']);
        if (request()->hasFile('avatar')) {
            try {
                $updated = $this->laboratory->update([
                    'avatar' => request()->avatar->store('public/avatar'),
                ]);
            } catch (Exception $x) {
                return response()->json(['message' => $x->getMessage()], 422);
            }

            return response()->json([
                'message' => ($updated ? 'Avatar Updated!' : 'No changes'),
                'path' => $this->laboratory->avatar,
            ]);
        }

        return response()->json(['message' => 'File: `Avatar` not found!']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($this->laboratory->update($request->all())) {
            return response()->json([
                'message' => 'Laboratory updated successfully ',
                'labs' => $this->laboratory,
            ], 200);
        }

        return response()->json([
            'message' => 'All data were submitted',
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
