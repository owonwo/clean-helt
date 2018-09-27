<?php

namespace App\Http\Controllers\API\Patient;

use App\Events\PatientSharedProfile;
use App\Events\ProfileShareExpired;
use App\Events\ProfileShareExtended;
use App\Models\ProfileShare;
use App\Notifications\PatientProfileSharedNotification;
use App\Traits\Utilities;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProfileShareController extends Controller
{
    use Utilities;

    private $patient;

    public function __construct()
    {
        $this->middleware('auth:patient-api');

        $this->middleware(function ($request, $next) {
            $this->patient = auth()->user();
            return $next($request);
        });
    }

    public function index()
    {
        return response()->json([
            'message' => 'Shares retrieved successfully',
            'shares' => $this->patient->profileShares
        ], 200);
    }

    public function store()
    {
        $rules = $this->getRules();
        try {
            $this->validate(request(), $rules);
        } catch (ValidationException $exception) {
            return response()->json([
                'errors' => $exception->errors(),
                'message' => $exception->getMessage(),
            ], 403);
        }

        $chcode = request('chcode');

        $providerClass = $this->getProvider($chcode);

        if ($providerClass && $provider = $providerClass::whereChcode($chcode)->first()) {

            $exists = DB::table('profile_shares')
                        ->where('patient_id', $this->patient->id)
                        ->where('provider_type', $providerClass)
                        ->where('provider_id', $provider->id)->first();

            if (!$exists) {
                $share = $this->patient->profileShares()->create([
                    'provider_type' => $providerClass,
                    'provider_id' => $provider->id,
                    'expired_at' => request('expiration')
                ]);
                //Fire an event that tells providers that patient has been shared
                event(new PatientSharedProfile($provider, $this->patient));

                if ($share) {
                    return response()->json([
                        'message' => 'Profile shared successfully',
                        'share' => $share
                    ], 200);
                }

            }
            return response()->json([
                'message' => 'Profile could not be shared at this time maybe you have shared'
            ], 400);
        }

        return response()->json(['message' => 'Provider not found'], 400);
    }

    public function expire(ProfileShare $profileShare)
    {
        if ($profileShare && $profileShare->update(['expired_at' => now()->subSeconds(30)])) {
            event(new ProfileShareExpired($profileShare->provider, $this->patient));
            return response()->json([
                'message' => 'Share expired successfully',
                'share' => $profileShare
            ], 200);
        }

        return response()->json([
            'message' => 'Share could not be expired at this time'
        ], 400);
    }

    public function extend(ProfileShare $profileShare)
    {
        $rules = ['extension' => 'required'];

        $this->validate(request(), $rules);

        $expired_at = request('extension');

        if ($profileShare && $profileShare->update(['expired_at' => $expired_at])) {

            event(new ProfileShareExtended($profileShare->provider, $this->patient));
            return response()->json([
                'message' => "Share extended successfully. Now expires " . $profileShare->fresh()->expired_at->diffForHumans(),
                'share' => $profileShare
            ], 200);
        }

        return response()->json([
            'message' => 'Share could not be extended at this time'
        ], 400);
    }

    public function pending()
    {
        $referredDoctor = ProfileShare::where([['patient_id', optional($this->patient)->id], ['referral_status', '=', null]])->get();

        if($referredDoctor)
        {
            return response()->json([
                'message' => 'Retrieve pending referred doctor',
                'data' => $referredDoctor
            ], 200);
        }

        return response()->json([
            'message' => 'Failed to fetch resource'
        ], 403);
    }

    public function accept(ProfileShare $profileShare)
    {
        if($profileShare->exists && $profileShare->update(['referral_status' => true])){

            return response()->json([
                'message' => 'Profile share has been accepted',
                'data' => $profileShare
            ], 200);
        }
        return response()->json([
            'message' => 'Profile share acceptance failed'
        ], 403);
    }

    public function decline(ProfileShare $profileShare)
    {
        if($profileShare->update(['referral_status' => false])){
            return response()->json([
                'message' => 'Profile share has been accepted',
                'data' => $profileShare
            ], 200);
        }
        return response()->json([
            'message' => 'Profile share acceptance failed'
        ],403);
    }

    private function getRules()
    {
        return [
            'chcode' => 'required',
            'expiration' => 'required|date|after_or_equal:now'
        ];
    }
}
