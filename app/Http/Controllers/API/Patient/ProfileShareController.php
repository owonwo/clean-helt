<?php

namespace App\Http\Controllers\API\Patient;

use App\Models\ProfileShare;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileShareController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:patient-api');
    }
    public function share(){
        $patient = auth()->guard('patient')->user();
        ProfileShare::forceCreate([
            'patient_id' => $patient->id,
            ''

        ]);
    }
    public function index()
    {
        $patient = auth()->guard('patient')->user();
        return response()->json([
            'message' => 'Shares retrieved successfully',
            'shares' => $patient->profileShares
        ], 200);
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
            return response()->json([
                'message' => "Share extended successfully. Now expires " . $profileShare->fresh()->expired_at->diffForHumans(),
                'share' => $profileShare
            ], 200);
        }

        return response()->json([
            'message' => 'Share could not be extended at this time'
        ], 400);
    }
}
