<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Hospital;
use App\Notifications\HospitalCreatedNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HospitalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin-api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hospitals = Hospital::latest()->paginate(20);

        return response()->json([
            'data' => $hospitals,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = $this->getRules();

        $this->validate($request, $rules);

        $data = $request->only(array_keys($rules));

        $password = str_random(10);
        $data['password'] = bcrypt($password);
        $data['avatar'] = 'public/defaults/avatars/provider.png';

        if ($hospital = Hospital::create($data)) {

            $delay = now()->addMinute(1);
            $hospital->notify((
                new HospitalCreatedNotification($hospital, $password)
            )->delay($delay));

            return response()->json([
                'message' => 'Hospital created successfully',
                'data' => $hospital,
            ], 200);
        }

        return response()->json([
            'message' => 'Hospital could not be created',
        ], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param Hospital $hospital
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Hospital $hospital)
    {
        return response()->json([
            'message' => 'Hospital fetched successfully',
            'data' => $hospital,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Hospital                 $hospital
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hospital $hospital)
    {
        if ($hospital->update($request->all())) {
            return response()->json([
                'message' => 'Hospital updated successfully',
                'data' => $hospital,
            ], 200);
        }

        return response()->json([
            'message' => 'Hospital could not be updated',
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Hospital $hospital
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hospital $hospital)
    {
        try {
            $hospital->delete();

            return response()->json([
                'message' => 'Hospital deleted successfully',
                'data' => $hospital,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Returns validation rules for hospital resource.
     *
     * @return array
     */
    private function getRules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:hospitals,email|max:255',
            'director_mdcn' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
        ];
    }
}
