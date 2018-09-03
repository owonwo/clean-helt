<?php

namespace App\Http\Controllers\API\Pharmacy;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PatientController extends Controller
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
            'message' => 'Patients retrieved successfully',
            'patients' => $this->pharmacy->patients()->get()
        ], 200);
    }
}
