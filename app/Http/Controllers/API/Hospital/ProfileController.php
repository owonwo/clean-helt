<?php

namespace App\Http\Controllers\API\Hospital;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    private $hospital;

    public function __construct()
    {
        $this->middleware('auth:hospital-api');
        $this->middleware(function($request, $next) {

            $this->hospital = auth()->user();

            return $next($request);
        });
    }

    public function index()
    {
        return response()->json([
            'message' => 'Hospital retrieved successfully',
            'hospital' => $this->hospital
        ], 200);
    }

    public function update(Request $request)
    {
        if ($this->hospital->update($request->all())) {
            return response()->json([
                'message' => 'Profile updated successfully',
                'hospital' => $this->hospital->fresh()
            ], 200);
        }

        return response()->json([
            'message' => 'Profile could not be updated'
        ], 400);
    }
}
