<?php

namespace App\Http\Controllers\API\Hospital;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:hospital-api');
    }

    public function index()
    {
        $hospital = auth()->guard('hospital')->user();
        return response()->json([
            'message' => 'Hospital retrieved successfully',
            'hospital' => $hospital
        ], 200);
    }

    public function update(Request $request)
    {
        $hospital = auth()->guard('hospital')->user();

        if ($hospital->update($request->all())) {
            return response()->json([
                'message' => 'Profile updated successfully',
                'hospital' => $hospital
            ], 200);
        }

        return response()->json([
            'message' => 'Profile could not be updated'
        ], 400);
    }
}
