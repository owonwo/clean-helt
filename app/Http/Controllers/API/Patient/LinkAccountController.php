<?php

namespace App\Http\Controllers\API\Patient;

use App\Mail\PatientVerifyEmail;
use App\Models\LinkedAccounts;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LinkAccountController extends Controller
{
    //


    public function store(Request $request)
    {

        $parent = auth()->guard('patient-api')->user();

        $rule = $this->getRegRule();

        try {
            $this->validate($request, $rule);
        } catch (ValidationException $exception) {
            dd($exception->errors());
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

            if ($patient = Patient::create(array_merge($data, $token))) {
                $accessToken = $patient->createToken(config('app.name'))->accessToken;
                $linkedAccounts = LinkedAccounts::forceCreate([
                   'patient_id' => $parent->id,
                    'child_id' => $patient->id
                ]);
                $this->sendConfirmationMail($patient);

                return response()->json([
                    'message' => 'Congratulation! you have successfully created patient record',
                    'data' => $patient,
                    'accessToken' => $accessToken,
                ], 200);
            }
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return response()->json([
                'errors' => 'Ooops! '.$exception->getMessage(),
            ], 403);
        }

        return response()->json([
            'message' => 'Your update failed due to incorrect data',
        ]);
    }
    public function sendConfirmationMail($patient)
    {
        Mail::to($patient['email'])->send(new PatientVerifyEmail($patient));
    }
    private function getRegRule()
    {
        return [
            'email' => 'required|email|max:190|unique:patients',
            'first_name' => 'required|string|max:60|min:2',
            'last_name' => 'required|string|max:60|min:2',
            'password' => 'required|max:32|min:6',
            'phone' => 'required|digits:11',
        ];
    }
    public function showLinkedAccounts(){
        $parent = auth()->guard('patient-api')->user();
        return response()->json([
            'message' => 'Linked accounts',
            'data' => $parent->children->each(function($child){
                return $child->account;
            })
        ],200);
    }
    public function switchAccount(){
        $patient = Patient::findOrFail(request('id'));

        $token = $patient->createToken(config('app.name'))->accessToken;;

        return response()->json([
           'message' =>  'Account switch successful',
            'data' => $patient,
            'accessToken' => $token
        ],200);
    }
}
