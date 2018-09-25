<?php

namespace App\Http\Controllers\API\Patient;

use App\Mail\PatientVerifyEmail;
use App\Models\Hospital;
use App\Models\Laboratory;
use App\Models\Patient;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Exception;                                             
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use App\Models\Doctor;


class PatientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:patient-api',['except' => ['store', 'verify']]);

        $this->middleware(function($request, $next) {
            $this->patient = auth()->user();
            return $next($request);
        });
    }

    public function store(Request $request)
    {
        $rule = $this->getRegRule();

        try {
            $this->validate($request, $rule);
        } catch (ValidationException $exception) {
            return response()->json([
                'errors' => $exception->errors(),
                'message' => $exception->getMessage(),
            ], 422);
        }

        try {

            $data = $request->all();

            $data['password'] = bcrypt($data['password']);

            $token = ['token' => str_random(40)];

            $data['verify_token'] = Str::random(40);
            $data['avatar'] = 'public/defaults/avatars/client.png';

            if($patient = Patient::create(array_merge($data, $token))){

                $accessToken = $patient->createToken(config('app.name'))->accessToken;

                $this->sendConfirmationMail($patient);

                return response()->json([
                    'message' => 'Congratulation! you have successfully created patient record',
                    'data' => $patient,
                    'accessToken' => $accessToken,
                ], 200);
            }

        } catch (\Exception $exception)
        {
            return response()->json([
                'errors' => 'Ooops! '.$exception->getMessage(),
            ], 403);
        }


        return response()->json([
            'message' => 'Your update failed due to incorrect data'
        ]);
    }

    public function verify($email, $verifyToken)
    {

        if($patient = Patient::where(['email' => $email, 'verify_token' => $verifyToken])->first())
        {
            $data['status'] = 1;
            $data['verify_token'] = null;
            if($patient->update($data)){
                return redirect('/login');
            }
        }

        return response()->json([
            'message' => 'Your account was not verified'
        ], 401);

    }

    public function sendConfirmationMail($patient)

    {
        Mail::to($patient['email'])->send(new PatientVerifyEmail($patient));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

        $patient = $this->patient;

        return response()->json([
            'message' => 'you have successfully log into your account',
            'data' => $patient,
        ], 200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Patient $patient)
    {
        $rules = [
            'emergency_hospital_address' => 'required',
            'emergency_hospital_name' => 'required|string|max:120',
        ];

        try {
            $this->validate($request, $rules);
        } catch (ValidationException $exception) {
            return response()->json([
                'errors' => $exception->errors(),
                'message' => $exception->getMessage(),
            ], 422);
        }


        try {

            $data = $request->all();

            if($patient->update($data)){
                return response()->json([
                    'message' => 'congratulation you have updated your emergency profile',
                    'data' => $patient,
                ]);
            }

        } catch (\Exception $e){
            return response()->json([
                'errors' => 'Ooops! ' .$e->getMessage(),
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        /**
         * @check if the patient is inserting an image of not
         */

        $rule = $this->getUpdateRule();

        try {
            $this->validate($request, $rule);
        } catch (ValidationException $exception) {
            return response()->json([
                'errors' => $exception->errors(),
                'message' => $exception->getMessage(),
            ], 422);
        }

        try {

            if(request()->hasFile('avatar'))
            {
                $avatarName = request()->avatar->store('public/avatar');
            }

            $data = request()->all();

            $data['avatar'] = $avatarName;

            if($this->patient->update($data)){
                return response()->json([
                    'message' => 'Your profile has been update successfully',
                    'data' => $this->patient,
                ], 200);
            }

        } catch (\Exception $exception) {
            return response()->json([
                'errors' => 'Ooops! '. $exception->getMessage(),
            ]);
        }

        return response()->json([
            'message' => 'Your update failed due to incorrect data'
        ], 200);
    }


    public function destroy($id)
    {
        //
    }

    public function showRecords()
    {
        try {
            return response()->json([
                'message' => "Medical records successfully Loaded",
                'data' => $this->patient->medicalRecords()->latest()->get()->each(function($record){
                    $record->data;
                    return $record;
                }),
            ], 200);
        } catch (Exception $exception){
            return response()->json([
                'errors' => 'Ooops! '.$exception->getMessage(),
            ], 403);
        }
    }

    public function showLabtest()
    {
        $data = $this->patient->medicalRecords('App\Models\LabTest')->latest()->get()->each(function($record){
            $record->data;
            return $record;
        });

        return response()->json([
            'message' => 'You can access all laboratory record here',
            'data' => $data,
        ], 200);
    }

    public function showPrescription(Patient $patient)
    {
        $data = $this->patient->medicalRecords('App\Models\Prescription')->latest()->get()->each(function($record){
            $record->data;
            return $record;
        });

        return response()->json([
            'message' => 'access medical record by date',
            'data' => $data,
        ], 200);
    }

    private function getRegRule()
    {
        return [
            'email' => 'required|email|max:190|unique:patients',
            'first_name' => 'required|string|max:60|min:2',
            'last_name' => 'required|string|max:60|min:2',
            'password' => 'required|max:32|min:6',
            'phone' => 'required|digit:11'
        ];
    }

    private function getUpdateRule()
    {
        return [
            'first_name' => 'required|string|max:60|min:2',
            'last_name' => 'required|string|max:60|min:2',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png|max:200',
        ];
    }

    public function showDoctor()
    {
        $chcode = request()->chcode;
        $doctor = Doctor::whereChcode($chcode)->get()->first();
        
        if ($doctor) {
            return response()->json([
                'message' => 'Doctor retrieved successfully',
                'data' => $doctor,
            ], 200);
        }

        return response()->json([
            'message' => 'Doctor not found',
            $doctor => null
        ], 404);

    }
}
