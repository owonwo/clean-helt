<?php

namespace App\Http\Controllers\API\Pharmacy;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    //
    use ResetsPasswords;

    protected $redirectTo = '/fish';
    //returns authentication guard of seller
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.pharmacy.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
    protected function broker()
    {
        return Password::broker('pharmacies');
    }
    protected function guard()
    {
        return Auth::guard('pharmacy');
    }

}
