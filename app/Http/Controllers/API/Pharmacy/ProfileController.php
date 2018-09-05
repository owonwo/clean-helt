<?php

namespace App\Http\Controllers\API\Pharmacy;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    private $pharmacy;

    public function __construct()
    {
        $this->middleware('auth:pharmacy-api');
        $this->middleware(function($request, $next) {

            $this->pharmacy = auth()->user();

            return $next($request);
        });
    }

    public function index()
    {
        return response()->json([
            'message' => 'Pharmacy retrieved successfully',
            'pharmacy' => $this->pharmacy
        ], 200);
    }

    public function update(Request $request)
    {
        if ($this->pharmacy->update($request->all())) {
            return response()->json([
                'message' => 'Profile updated successfully',
                'pharmacy' => $this->pharmacy
            ], 200);
        }

        return response()->json([
            'message' => 'Profile could not be updated'
        ], 400);
    }
}
