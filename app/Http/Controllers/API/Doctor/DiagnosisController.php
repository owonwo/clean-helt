<?php

namespace App\Http\Controllers\API\Doctor;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiagnosisController extends Controller
{
    public function index(Patient $patient)
    {
        return response()->json(['patient' => $patient], 200);
    }

    public function store(Request $request)
    {

    }
}
