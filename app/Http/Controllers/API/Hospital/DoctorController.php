<?php

namespace App\Http\Controllers\API\Hospital;

use App\Models\Doctor;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
    private $hospital;

    public function __construct()
    {
        $this->middleware('auth:hospital-api');

        $this->middleware(function($request, $next) {

            $this->hospital = auth()->user();

            return $next($request);
        });
    }

    public function index()
    {
        return response()->json([
            'message' => 'Doctors retrieved successfully',
            'doctors' => $this->hospital->activeDoctors()->get()
        ], 200);
    }

    public function pending()
    {
        return response()->json([
            'message' => 'Doctors retrieved successfully',
            'doctors' => $this->hospital->pendingDoctors()->get()
        ], 200);
    }

    public function sent()
    {
        return response()->json([
            'message' => 'Doctors retrieved successfully',
            'doctors' => $this->hospital->sentDoctors()->get()
        ], 200);
    }

    public function invite(Doctor $doctor)
    {
        //TODO check if an invite exists already
        if ($doctor->exists) {
            $this->hospital->doctors()
                ->attach($doctor, ['actor' => 'App\Models\Hospital']);
            return response()->json([
                'message' => 'Doctor invite sent successfully'
            ], 200);
        }

        return response()->json([
            'message' => 'Doctor invite could not be sent'
        ], 400);
    }

    public function accept(Doctor $doctor)
    {
        if ($doctor->exists && $this->hospital->acceptDoctor($doctor))
        {
            return response()->json([
                'message' => 'Doctor approved successfully'
            ], 200);
        }
        return response()->json([
            'message' => 'Doctor invite could not be approved'
        ], 400);
    }

    public function decline(Doctor $doctor)
    {
        if ($doctor->exists && $this->hospital->declineDoctor($doctor))
        {
            return response()->json([
                'message' => 'Doctor declined successfully'
            ], 200);
        }
        return response()->json([
            'message' => 'Doctor invite could not be declined'
        ], 400);
    }

    public function remove(Doctor $doctor)
    {
        if ($doctor->exists && $this->hospital->doctors()->detach($doctor->id))
        {
            return response()->json([
                'message' => 'Doctor removed successfully'
            ], 200);
        }
        return response()->json([
            'message' => 'Doctor could not be removed'
        ], 400);
    }
}
