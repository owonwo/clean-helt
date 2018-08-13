<?php

namespace App\Http\Controllers\API\Hospital;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:hospital-api');
    }

    public function index()
    {
        $hospital = auth('hospital')->user();

        return response()->json([
            'message' => 'Doctors retrieved successfully',
            'doctors' => $hospital->doctors
        ], 200);
    }
}
