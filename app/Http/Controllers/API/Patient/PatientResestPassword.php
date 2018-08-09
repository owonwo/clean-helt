<?php

namespace App\Http\Controllers\API\Patient;

use Auth;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;

class PatientResestPassword extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/patients';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:patient-api');
    }

    public function showResetForm(Request $request, $token = null) {
        return view('mail.patientforgotpassword.resetpassword')
            ->with(['token' => $token, 'email' => $request->email]
            );
    }


    //defining which guard to use in our case, it's the admin guard
    protected function guard()
    {
        return Auth::guard('patient-api');
    }

    //defining our password broker function
    protected function broker() {
        return Password::broker('patients');
    }
}
