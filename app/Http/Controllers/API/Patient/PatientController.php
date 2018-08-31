<?php

namespace App\Http\Controllers\API\Patient;

use App\Mail\PatientVerifyEmail;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;


class PatientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:patient-api')->except('store', 'verify');
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

        try {
            $this->validate($request, $rule);
        } catch (ValidationException $exception) {
            return response()->json([
                'errors' => $exception->errors(),
                'message' => $exception->getMessage(),
            ]);
        }

        $data = $request->all();

        $data['password'] = bcrypt($data['password']);

        $token = ['token' => str_random(40)];

        $data['verifyToken'] = Str::random(40);

        if($patient = Patient::create(array_merge($data, $token))){

            $accessToken = $patient->createToken(config('app.name'))->accessToken;

            $this->sendConfirmationMail($patient);

            return response()->json([
                'message' => 'Congratulation! you have successfully created patient record',
                'patients' => $patient,
                'accessToken' => $accessToken,
            ], 200);
        }

        return response()->json([
            'message' => 'Your update failed due to incorrect data'
        ]);
    }

    public function verify($email, $verifyToken)
    {

        if($patient = Patient::where(['email' => $email, 'verifyToken' => $verifyToken])->first())
        {
            $data['status'] = 1;
            $data['verifyToken'] = '';
            if($patient->update($data)){
                return response()->json([
                    'message' => 'Congratulation you have just verified you account, login to continue',
                    'patient' => $patient,
                ], 200);
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
            'email' => 'required|email|max:190|unique:patients',
            'first_name' => 'required|string|max:60|min:2',
            'last_name' => 'required|string|max:60|min:2',
            'password' => 'required|max:32|min:6',
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
