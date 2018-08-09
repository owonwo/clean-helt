<?php

namespace App\Http\Controllers\API\Laboratory;

use Auth;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;

class LaboratoryResetPasswordController extends Controller
{

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/laboratory';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:laboratory-api');
    }

    public function showResetForm(Request $request, $token = null) {
        return view('mail.laboratoryforgotpassword.resetpassword')
            ->with(['token' => $token, 'email' => $request->email]
            );
    }


    //defining which guard to use in our case, it's the admin guard
    protected function guard()
    {
        return Auth::guard('laboratory-api');
    }

    //defining our password broker function
    protected function broker() {
        return Password::broker('laboratories');
    }
}
