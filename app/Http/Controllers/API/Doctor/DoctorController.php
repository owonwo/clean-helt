<?php

namespace App\Http\Controllers\API\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorProfile;
use App\Models\DoctorHospital;
use App\Models\Hospital;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Log;

class DoctorController extends Controller
{
    private $doctor;

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
            DoctorProfile::forceCreate([
                'doctors_id' => $doctor->id,
                'avatar' => 'public/defaults/avatars/client.png'
            ]);
            event(new Registered($doctor));

            $accessToken = $doctor->createToken(config('app.name'))->accessToken;

            return response()->json([
                'message' => 'Doctor has been created successfully',
                'access_token' => $accessToken,
                'doctor' => $doctor,
            ], 200);
        }

        return response()->json([
            'message' => 'There was an error',
        ], 400);
    }

    public function update()
    {
        $file = null;
        $doctor = auth()->guard('doctor-api')->user();

        // $doctor->save();
        // request()->validate($this->rules);
        // return json_encode(dd(request()->all()));
        Log::info(request()->all());

        try {
            $doctor->update([
                'first_name' => null == request('first_name') ? $doctor->first_name : request('first_name'),
                'middle_name' => null == request('middle_name') ? $doctor->middle_name : request('middle_name'),
                'last_name' => null == request('last_name') ? $doctor->last_name : request('last_name'),
                'email' => null == request('email') ? $doctor->email : request('email'),
                'phone' => null == request('phone') ? $doctor->phone : request('phone'),
                'gender' => null == request('gender') ? $doctor->gender : request('gender'),
                'specialization' => null == request('specialization') ? $doctor->specialization : request('specialization'),
                'folio' => null == request('folio') ? $doctor->folio : request('folio'),
            ]);

            $doctor->profile()->update([
                    'address' => request('address'),
                    'city' => request('city'),
                    'state' => request('state'),
                    'country' => request('country'),
                    'mode_of_contact' => request('mode_of_contact'),
                    'marital_status' => request('marital_status'),
                    'religion' => request('religion'),
                    'kin_fullname' => request('kin_fullname'),
                    'kin_address' => request('kin_address'),
                    'kin_phone' => request('kin_phone'),
                    'kin_city' => request('kin_city'),
                    'kin_state' => request('kin_state'),
                    'kin_country' => request('kin_country'),
                    'name_of_degree' => request('name_of_degree'),
                    'institution' => request('institution'),
                    'additional_degree' => request('additional_degree'),
                    'years_in_practice' => request('years_in_practice'),
                    'avatar' => $file = null == request()->file('avatar') ? $doctor->avatar : $file->store('avatar'),
                    'disability' => request('disability'),
                ]);

            return response()->json([
                'message' => 'Doctor updated successfully',
                'doctor' => $doctor->fresh(),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'There was an error',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function show()
    {
        $doctor = auth()->guard('doctor-api')->user();
        try {
            return response()->json([
                'message' => 'Doctors Loaded successfully',
                'doctor' => $doctor,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 403);
        }
    }

    public function addHospital()
    {
        $doctor = auth()->guard('doctor-api')->user();
        $chcode = request('chcode');

        try {
            $hospital = Hospital::whereChcode($chcode)->get()->first();
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Theres an Error'.$e->getMessage(),
            ], 403);
        }
        $exists = DB::table('doctor_hospital')->where('hospital_id', $hospital->id)->where('doctor_id', $doctor->id)->first();
        try {
            if (!$exists) {
                DoctorHospital::forceCreate([
                    'hospital_id' => $hospital->id,
                    'doctor_id' => $doctor->id,
                    'actor' => get_class($doctor),
                ]);
            } else {
                return response()->json([
                    'message' => 'You have added this hospital already.',
                ], 409);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Theres an Error'.$e->getMessage(),
            ], 403);
        }

        return response()->json([
            'message' => 'Please wait for hospital to accept you',
            'hospital' => $hospital,
        ]);

        //doctor first submits
    }

    public function accept(Hospital $hospital)
    {
        $doctor = auth()->guard('doctor-api')->user();
        if ($hospital->exists && $doctor->acceptHospital($hospital)) {
            return response()->json([
                'message' => 'You have successfully accepted',
            ], 200);
        }

        return response()->json([
            'error' => 'Something went wrong',
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
                'error' => $e->getMessage(),
            ], 403);
        }
    }

    public function activeHospitals()
    {
        $doctor = auth()->guard('doctor-api')->user();
        try {
            $activeHospitals = optional($doctor)->activeHospitals()->get();

            return response()->json([
                'message' => 'Active Hospitals loaded successfully',
                'hospitals' => $activeHospitals,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
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
                'hospitals' => $pendingHospitals,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 403);
        }
    }

    public function sentHospitals()
    {
        $doctor = auth()->guard('doctor-api')->user();

        try {
            $sentHospitals = optional($doctor)->sentHospitals()->get();

            return response()->json([
                'message' => 'Sent Hospitals loaded successfully',
                'hospitals' => $sentHospitals,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 403);
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
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function decline(Hospital $hospital)
    {
        $doctor = auth()->guard('doctor-api')->user();
        if ($hospital->exists && $doctor->declineHospital($hospital)) {
            return response()->json([
                'message' => 'You have successfully declined',
            ], 200);
        }

        return response()->json([
            'message' => 'Something went wrong',
        ], 400);
    }

    public function remove(Hospital $hospital)
    {
        $doctor = auth()->guard('doctor-api')->user();
        if ($hospital->exists && $doctor->hospitals()->detach($hospital->id)) {
            return response()->json([
                'message' => 'You have successfully Removed',
            ], 200);
        }

        return response()->json([
            'message' => 'Something went wrong',
        ], 400);
    }
}
