<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:admin-api');
    }

    public function index()
    {
        $patients = Patient::latest()->paginate(15);

        return response()->json([
            'data' => $patients,
        ], 200);
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

        $rules = [
            'first_name' => 'required|string|max:60',
            'last_name' => 'required|string|max:60',
            'email' => 'required|string|max:60|unique:patients',
            'phone' => 'required|digits:11|max:60|unique:patients',
        ];

        try {
            $this->validate($request, $rules);
        } catch (ValidationException $exception) {
            return response()->json([
                'errors' => $exception->errors(),
                'message' => $exception->getMessage(),
            ], 422);
        }

        $data = $request->all();

        $data['password'] = str_random(10);

        if ($patients = Patient::create($data)) {
            return response()->json([
                'message' => 'Patient created successfully',
                'data' => $patients,
            ], 200);
        }

        return response()->json([
            'message' => 'All data were submitted',
        ], 400);
    }

    public function deactivate(Patient $patient)
    {
        $patient->update([
            'active' => false,
        ]);

        return response()->json([
            'data' => $patient,
            'message' => 'Deactivated successfully',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        return response()->json(
            ['message' => 'Laboratory fetched successfully',
            'data' => $patient,
            ], 200
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        if ($patient->update($request->all())) {
            return response()->json([
                'message' => 'Laboratory updated successfully ',
                'data' => $patient,
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
    public function destroy(Patient $patient)
    {
        try {
            $patient->delete();

            return response()->json([
                'message' => 'Patient was successfully deleted ',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
