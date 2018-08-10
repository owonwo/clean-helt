<?php

namespace App\Http\Controllers\API\Laboratory;

use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;


class LaboratoryForgotPasswordController extends Controller
{
    /** Passsword reset controller
     *model responsible for handling forgot password
     */

    use SendsPasswordResetEmails;

    /** create controller instands
     *that is nice
     */

    public function __construct()
    {
        $this->middleware('guest:laboratory-api');
    }

    public function showLinkRequestForm()
    {
        /**
         * return laboratory view files
         * to enable lab send email auth
         * not done waiting for UI
         *
         */
        return view('mail.laboratoryforgotpassword.forgotpassword');
    }

    protected function broker() {
        return Password::broker('laboratories');
    }
}
