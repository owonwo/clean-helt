<?php

namespace App\Http\Controllers\API\Hospital;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:hospital-api');
    }

    public function index()
    {
        $hospital = auth()->guard('hospital')->user();

        return response()->json([
            'message' => 'Patients retrieved successfully',
            'patients' => $hospital->patients()->get()
        ], 200);
    }
}
