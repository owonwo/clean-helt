<?php

namespace App\Http\Controllers\API\Doctor ;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorHospital;
use App\Models\Hospital;
use Illuminate\Auth\Events\Registered;


class DoctorController extends Controller
{
    //
    private $doctor;
    protected $rules = [
        'first_name' => 'required|string|min:3|max:255',
        'last_name' => 'required|string|min:3|max:255',
        'middle_name' => 'required|string|min:3|max:255',
        'email' => 'required|string|email|max:255|unique:doctors',
        'password' => 'required|min:6',
        'phone' => 'required|unique:doctors',
        'gender' => 'required|string',
        'specialization' => 'required|string',
        'folio' => 'required|string',//folio is that doctors bar
    ];
    public function __construct(){
        $this->doctor = auth('doctor-api')->user();
    }
    public function store(){

        request()->validate($this->rules);

        $data = request()->all();
        $token = ['token' => str_random(40)];
        if($doctor = Doctor::forceCreate(array_merge($data,$token))){
            event(new Registered($doctor));
            $accessToken = $doctor->createToken(config('app.name'))->accessToken
            return response()->json([
                'message' => "Doctor has been created successfully",
                'accessToken' => $accessToken,
                'doctor' => $doctor
            ],200);
        }
            return response()->json([
                'message' => "There was an error"
            ],400);
    }
    public function update(){

      if($this->doctor->profile->update(request()->all()) || $this->doctor->update(request()->all())){
         return request()->json([
              'message' => 'Doctor updated successfully',
              'doctor' => $this->doctor
          ],200);
      }
          return request()->json([
              'message' => "Fuck!! it failed to update",
          ],400);
    }
    public function show(){
        $this->doctor->profile;

        return response()->json([
            'message' => 'Doctors Loaded successfully',
            'doctor' => $this->doctor
        ]);
    }
    public function passwordReset() {

    }
    public function showDate() {

    }
    public function addHospital(){
       $chcode = request('chcode');
       $hospital = Hospital::whereChcode($chcode)->get()->first();

       DoctorHospital::forceCreate([
           'hospital_id' => $hospital->id,
           'doctor_id' => $this->doctor->id,
           'actor' => get_class($this->doctor)
       ]);

       return response()->json([
          'message' => 'Please wait for hospital to accept you',
           'hospital' => $hospital
       ]);
        //doctor first submits
    }

    public function accept(Hospital $hospital){
        if($hospital->exists && $this->doctor->acceptHospital($hospital)){
            return response()->json([
                'message' => 'You have successfully accepted'
            ],200);
        }
            return response()->json([
                'message' => 'Something went wrong'
            ],400);
    }
    public function readNotifications(Doctor $doctor){
        dd($doctor->unreadNotifications);
        foreach ($doctor->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
    }
    public function activeHospitals(){
        $activeHospitals = $this->doctor->activeHospitals()->get();
        return response()->json([
            'message' => 'Active Hospitals loaded successfully',
            'activeHospitals' => $activeHospitals
        ]);
    }
    public function pendingHospitals(){
        $pendingHospitals = $this->doctor->pendingHospitals()->get();
        return response()->json([
           'message' => 'Pending hospitals Loaded Successfully',
            'pendingHospitals' => $pendingHospitals
        ]);
    }
    public function sentHospitals(){
        $sentHospitals = $this->doctor->sentHospitals()->get();
        return response()->json([
           'message' => 'Sent Hospitals loaded successfully',
            'sentHospitals' => $sentHospitals
        ]);
    }
    public function decline(Hospital $hospital){
        if($hospital->exists && $this->doctor->declineHospital($hospital)){
            return response()->json([
                'message' => 'You have successfully declined'
            ],200);
        }
        return response()->json([
            'message' => 'Something went wrong'
        ],400);
    }
    public function remove(Hospital $hospital){
        if($hospital->exists && $this->doctor->hospitals()->detach($hospital->id)){
            return response()->json([
                'message' => 'You have successfully Removed'
            ],200);
        }
        return response()->json([
            'message' => 'Something went wrong'
        ],400);
    }
}
