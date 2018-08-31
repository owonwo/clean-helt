<?php

namespace App\Http\Controllers\API\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorHospital;
use App\Models\Hospital;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;

class DoctorController extends Controller
{

    //
    public function __construct()
    {
        $this->middleware('auth:doctor-api')->except('store');
    }

    protected $rules = [
        'first_name' => 'required|string|min:3|max:255',
        'last_name' => 'required|string|min:3|max:255',
        'middle_name' => 'required|string|min:3|max:255',
        'email' => 'required|string|email|max:255|unique:doctors',
        'password' => 'required|min:6',
        'phone' => 'required|unique:doctors',
        'gender' => 'required|string',
        'specialization' => 'required|string',
        'folio' => 'required|string', //folio is that doctors bar
    ];

    public function store()
    {
        try {
            request()->validate($this->rules);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
                'message' => $e->getMessage(),
            ], 422);
        }
        $data = request()->all();
        $data['password'] = bcrypt($data['password']);
        $token = ['token' => str_random(40)];
        if ($doctor = Doctor::forceCreate(array_merge($data, $token))) {
            event(new Registered($doctor));

            $accessToken = $doctor->createToken(config('app.name'))->accessToken;

            return response()->json([
                'message' => 'Doctor has been created successfully',
                'accessToken' => $accessToken,
                'doctor' => $doctor
            ], 200);
        }
        return response()->json([
            'message' => "There was an error"
        ], 400);
    }

    public function update()
    {
        $doctor = auth()->guard('doctor-api')->user();
        if ($doctor->profile->update(request()->all()) || $doctor->update(request()->all())) {
            return response()->json([
                'message' => 'Doctor updated successfully',
                'doctor' => $doctor
            ], 200);
        }
        return response()->json([
                'message' => 'There was an error',
            ], 400);
    }

    public function show(Doctor $doctor)
    {

        try {
            return response()->json([
                'message' => 'Doctors Loaded successfully',
                'doctor' => $doctor,
                'doctorProfile' => $doctor->profile,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 403);
        }

    }
    public function addHospital()
    {
        $doctor = auth()->guard('doctor-api')->user();
        $chcode = request('chcode');
        $hospital = Hospital::whereChcode($chcode)->get()->first();


        try {
            DoctorHospital::forceCreate([
                'hospital_id' => $hospital->id,
                'doctor_id' => $doctor->id,
                'actor' => get_class($doctor)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Theres an Error' . $e->getMessage()
            ],403);
        }

        return response()->json([
            'message' => 'Please wait for hospital to accept you',
            'hospital' => $hospital
        ]);

        //doctor first submits
    }

    public function accept(Hospital $hospital)
    {
        $doctor = auth()->guard('doctor-api')->user();
        if ($hospital->exists && $doctor->acceptHospital($hospital)) {
            return response()->json([
                'message' => 'You have successfully accepted'
            ], 200);
        }
        return response()->json([
            'error' => 'Something went wrong'
        ], 400);

    }

    public function readNotifications(Doctor $doctor)
    {
        try {
            foreach ($doctor->unreadNotifications as $notification) {
                $notification->markAsRead();
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ],403);

        }
    }

    public function activeHospitals()
    {
        $doctor = auth()->guard('doctor-api')->user();
        try {
            $activeHospitals = optional($doctor)->activeHospitals()->get();
            return response()->json([
                'message' => 'Active Hospitals loaded successfully',
                'activeHospitals' => $activeHospitals
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }

    }

    public function pendingHospitals()
    {
        $doctor = auth()->guard('doctor-api')->user();

        try {
            $pendingHospitals = optional($doctor)->pendingHospitals()->get();
            return response()->json([
                'message' => 'Pending hospitals Loaded Successfully',
                'pendingHospitals' => $pendingHospitals
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ],403);
        }

    }

    public function sentHospitals()
    {
        $doctor = auth()->guard('doctor-api')->user();

        try {
            $sentHospitals = optional($doctor)->sentHospitals()->get();
            return response()->json([
                'message' => 'Sent Hospitals loaded successfully',
                'sentHospitals' => $sentHospitals,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ],403);
        }
    }

    public function hospitals()
    {
        $doctor = auth()->guard('doctor-api')->user();
        try {
            return response()->json([
                'message' => 'This hospitals loaded successfully',
                'hospitals' => $doctor->hospitals,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }

    }

    public function decline(Hospital $hospital)
    {
        $doctor = auth()->guard('doctor-api')->user();
        if ($hospital->exists && $doctor->declineHospital($hospital)) {
            return response()->json([
                'message' => 'You have successfully declined'
            ], 200);
        }
        return response()->json([
            'message' => 'Something went wrong'
        ], 400);
    }

    public function remove(Hospital $hospital)
    {
        $doctor = auth()->guard('doctor-api')->user();
        if ($hospital->exists && $doctor->hospitals()->detach($hospital->id)) {
            return response()->json([
                'message' => 'You have successfully Removed'
            ], 200);
        }

        return response()->json([
            'message' => 'Something went wrong'
        ], 400);
    }
}
