<?php

namespace App\Http\Controllers\API\Patient;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:patient-api')->except('store');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('patient.login')->with('user', Auth::user());
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
        $rule = $this->getRegRule();

        $this->validate($request, $rule);

        $data = $request->all();

        $token = ['token' => str_random(40)];

        if($patient = Patient::create(array_merge($data, $token))){

            return response()->json([
                'message' => 'Congratulation! you have successfully created patient record',
                'patients' => $patient,
            ], 200);
        }

        return response()->json([
            'message' => 'Your update failed due to incorrect data'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        return response()->json([
            'message' => 'you have successfully log into your account',
            'patient' => $patient,
        ], 200);

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
    public function update(Request $request, Patient $patient)
    {
        /**
         * @check if the patient is inserting an image of not
         */

        $rule = $this->getUpdateRule();

        $this->validate($request, $rule);

        if($request->hasFile('avatar'))
        {
            $avatarName = $request->avatar->store('public/avatar');
        }else{
            $avatarName = 'avatar/avatar.jpeg';
        }

        $data = $request->all();

        $data['avatar'] = $avatarName;

        if($patient->update($data)){
            return response()->json([
                'message' => 'Your profile has been update successfully',
                'patient' => $patient,
            ], 200);
        }

        return response()->json([
            'message' => 'Your update failed due to incorrect data'
        ], 200);
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

    public function showRecords(Patient $patient)
    {
        return response()->json([
            'message' => "Medical records successfully Loaded",
            'records' => $patient->medicalRecords
        ], 200);
    }

    public function showDate(Patient $patient)
    {
        $patient = $patient->medicalRecords()->latest()->first();

        return response()->json([
            'message' => 'access medical record by date',
            'patient' => $patient,
        ], 200);
    }

    public function showLabtest(Patient $patient)
    {
        $patient = $patient->laboratoryRecords()->latest()->first();


        return response()->json([
            'message' => 'You can access all laboratory record here',
            'patient' => $patient,
        ], 200);
    }

    public function showPrescription(Patient $patient)
    {
        $patient = $patient->pharmacyRecords()->latest()->first();

        return response()->json([
            'message' => 'access medical record by date',
            'patient' => $patient,
        ], 200);
    }

    private function getRegRule()
    {
        return [
            'email' => 'required|email|max:190|unique:patient',
            'first_name' => 'required|string|max:60|min:2',
            'last_name' => 'required|string|max:60|min:2',
            'password' => 'required|confirmed|max:32|min:6',
        ];
    }

    private function getUpdateRule()
    {
        return [
            'email' => 'required|email|max:190|unique:patient',
            'first_name' => 'required|string|max:60|min:2',
            'last_name' => 'required|string|max:60|min:2',
            'password' => 'required|confirmed|max:32|min:6',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png|max:200',
        ];
    }
}
