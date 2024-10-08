<?php

namespace App\Http\Controllers\API\Laboratory;

use App\Models\ProfileShare;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileShareController extends Controller
{
    private $laboratory;

    public function __construct()
    {
        $this->middleware('auth:laboratory-api');

        $this->middleware(function ($request, $next) {
            $this->laboratory = auth()->user();

            return $next($request);
        });
    }

    public function index()
    {
        return response()->json(
            [
                'message' => 'You can view patient update profile',
                'patients' => $this->laboratory->patients()->get(),
            ],
            200
        );
    }

    public function pending()
    {
        return response()->json([
           'message' => 'Patient Shared his medical record',
            'patients' => $this->laboratory->pendingShares()->get(),
        ], 200);
    }

    public function accept(ProfileShare $profileShare)
    {
        if ($profileShare->exists && $profileShare->update(['status' => '1'])) {
            return response()->json([
                'message' => 'You have accept patient profile for a period of time',
                'patient' => $profileShare,

            ], 200);
        }

        return response()->json([
            'message' => 'Sorry! for some reason you cannot accept patient profile'
        ], 400);
    }

    public function decline(ProfileShare $profileShare)
    {
        if ($profileShare->exists && $profileShare->update(['status' => 2])) {
            return response()->json([
                'message' => "You've just decline a patient profile share!",
                'patient' => $profileShare,
            ], 200);
        }

        return response()->json([
            'message' => 'for some reason you decline was rejected',
        ], 400);
    }
}
