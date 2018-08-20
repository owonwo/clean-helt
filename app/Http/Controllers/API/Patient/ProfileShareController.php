<?php

namespace App\Http\Controllers\API\Patient;

use App\Events\PatientSharedProfile;
use App\Events\ProfileShareExtended;
use App\Models\ProfileShare;
use App\Notifications\PatientProfileSharedNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileShareController extends Controller
{
    private $patient;

    public function __construct()
    {
        $this->middleware('auth:patient-api');
        $this->patient = auth()->guard('patient')->user();
    }

    public function index()
    {
        $patient = auth()->guard('patient')->user();
        return response()->json([
            'message' => 'Shares retrieved successfully',
            'shares' => $patient->profileShares
        ], 200);
    }

    public function store()
    {
        $rules = $this->getRules();

        $this->validate(request(), $rules);

        $chcode = request('chcode');

        $providerClass = $this->getProvider($chcode);

        if ($providerClass && $provider = $providerClass::whereChcode($chcode)->first()) {

            $share = $this->patient->profileShares()->create([
                'provider_type' => $providerClass,
                'provider_id' => $provider->id,
                'expired_at' => request('expiration')
            ]);
            //Fire an event that tells providers that patient has been shared
            event(new PatientSharedProfile($provider,$this->patient));
            if ($share) {
                return response()->json([
                    'message' => 'Profile shared successfully',
                    'share' => $share
                ], 200);
            }

            return response()->json([
                'message' => 'Profile could not be shared at this time'
            ], 400);
        }

        return response()->json(['message' => 'Provider not found'], 400);
    }

    public function expire(ProfileShare $profileShare)
    {
        if ($profileShare && $profileShare->update(['expired_at' => now()->subSeconds(30)])) {
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
            event(new ProfileShareExtended($profileShare->provider,$this->patient));
            return response()->json([
                'message' => "Share extended successfully. Now expires " . $profileShare->fresh()->expired_at->diffForHumans(),
                'share' => $profileShare
            ], 200);
        }

        return response()->json([
            'message' => 'Share could not be extended at this time'
        ], 400);
    }

    private function getProvider($code)
    {
        $prefixes = config('ch.chcode_prefixes');

        $prefix = substr($code, 0, 3);

        return @$prefixes[$prefix];
    }

    private function getRules()
    {
        return [
            'chcode' => 'required',
            'expiration' => 'required|date|after_or_equal:now'
        ];
    }
}
