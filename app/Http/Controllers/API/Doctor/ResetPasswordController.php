<?php

namespace App\Http\Controllers\API\Auth;


use App\Http\Controllers\Controller;
//Auth Facade
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//Password Broker Facade
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    //
    use ResetsPasswords;

    protected $redirectTo = '/fish';
    //returns authentication guard of seller
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
    protected function broker()
    {
        return Password::broker('doctors');
    }
    protected function guard()
    {
        return Auth::guard('doctor');
    }
}
