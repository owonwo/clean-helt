<?php

namespace App\Http\Controllers\API\Laboratory;

use App\Models\ProfileShare;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileShareController extends Controller
{

    function __construct()
    {
        $this->laboratory = auth()->guard('laboratory')->user();
    }

    public function index()
    {
        return response()->json(
            [
                'message' => 'You can view patient update profile',
                'laboratory' => $this->laboratory->patients()->get(),
            ], 200
        );
    }

    public function pending()
    {

        return response()->json([
           'message' => 'Patient Shared his medical record',
            'laboratory' => $this->laboratory->pendingShares()->get(),
        ], 200);
    }

    public function accept(ProfileShare $profileShare)
    {
        if($profileShare->exists && $profileShare->update(['status' => '1']))
        {
            return response()->json([
                'message' => 'You have accept patient profile for a period of time',
                'laboratory' => $profileShare,

            ], 200);
        }

        return response()->json([
            'message' => 'Sorry! for some reason you cannot accept patient profile'
        ], 400);
    }

    public function decline(ProfileShare $profileShare)
    {

        if($profileShare->exists && $profileShare->update(['status' => 2]))
        {

            return response()->json([
                'message' => "You've just decline a patient profile share!",
                'laboratory' => $profileShare,
            ],200);
        }

        return response()->json([
            'message' => 'for some reason you decline was rejected',
        ], 400);
    }


}
