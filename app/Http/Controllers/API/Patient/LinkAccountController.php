<?php

namespace App\Http\Controllers\API\Patient;

use App\Http\Controllers\Controller;
use App\Mail\PatientVerifyEmail;
use App\Models\LinkedAccounts;
use App\Models\Patient;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LinkAccountController extends Controller
{
    //

    public function store(Request $request)
    {
        $parent = auth()->guard('patient-api')->user();

        try {
            $this->validate($request, $this->getRegRule());
        } catch (ValidationException $exception) {
            return response()->json([
                'errors' => $exception->errors(),
                'message' => $exception->getMessage(),
            ], 422);
        }

        try {
            $data = $request->all();
            $other_data = [
                'token' => str_random(40),
                'verify_token' => Str::random(40),
                'password' => bcrypt($data['password']),
                'avatar' => 'public/defaults/avatars/client.png',
            ];

            if ($child = Patient::create(array_merge($data, $other_data))) {
                $accessToken = $child->createToken(config('app.name'))->accessToken;
                $linkedAccounts = LinkedAccounts::forceCreate([
                   'patient_id' => $parent->id,
                   'child_id' => $child->id,
                ]);
                $this->sendConfirmationMail($child);

                return response()->json([
                    'data' => $child,
                    'accessToken' => $accessToken,
                    'message' => 'Congratulation! you have successfully created patient record',
                ], 200);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'errors' => 'Ooops! ' . $exception->getMessage(),
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

    public function showLinkedAccounts()
    {
        $parent = auth()->guard('patient-api')->user();

        return response()->json([
            'message' => 'Linked accounts',
            'data' => $parent->children->each(function ($child) {
                return $child->account;
            }),
        ], 200);
    }

    public function switchAccount()
    {
        $patient = auth()->guard('patient-api')->user();
        if ($patient->hasChild(request('id'))) {
            $child = Patient::find(request('id'));
            $token = $child->createToken(config('app.name'))->accessToken;

            return response()->json([
                'data' => $child,
                'accessToken' => $token,
                'message' => 'Account switch successful',
            ], 200);
        }

        throw new ModelNotFoundException('Patient is not a child.');
    }

    /**
     * Unlinks an account from the auth_user
     *
     * @return JsonResponse
     * @author Joseph Owonvwon
     **/
    public function unlinkAccount()
    {
        $child = request('id');
        $patient = auth()->guard('patient-api')->user();

        if ($patient->hasChild($child)) {
            if ($patient->unlinkChild($child)) {
                return response()->json(['message' => 'Child Unlinked']);
            }
        }

        return response()->json(['message' => 'Failed to unlink child'], 400);
    }
}
