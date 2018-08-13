<?php

namespace App\Http\Controllers\API\Hospital;

use App\Models\ProfileShare;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileShareController extends Controller
{
    public function accept(ProfileShare $profileShare)
    {
        if ($profileShare->exists && $profileShare->isActive) {
            $profileShare->update(['status' => 1]);

            return response()->json([
                'message' => 'Profile share accepted successfully',
                'share' => $profileShare
            ], 200);
        }

        return response()->json([
            'message' => 'Profile share could not be accepted at this time'
        ], 400);
    }

    public function decline(ProfileShare $profileShare)
    {
        if ($profileShare->exists && $profileShare->isActive) {
            $profileShare->update(['status' => 2]);

            return response()->json([
                'message' => 'Profile share declined successfully',
                'share' => $profileShare
            ], 200);
        }

        return response()->json([
            'message' => 'Profile share could not be declined at this time'
        ], 400);
    }
}
