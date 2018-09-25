<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Pharmacy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pharmacies = Pharmacy::latest()->paginate(20);

        return response()->json([
            'data' => $pharmacies,
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

        $data = $request->all();

        $data['password'] = str_random(10);

        if ($pharmacy = Pharmacy::create($data)) {
            return response()->json([
                'message' => 'Pharmacy created successfully',
                'data' => $pharmacy,
            ], 200);
        }

        return response()->json([
            'message' => 'Pharmacy could not be created',
        ], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Pharmacy $pharmacy)
    {
        return response()->json([
            'message' => 'Pharmacy fetched successfully',
            'data' => $pharmacy,
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
     * @param Pharmacy                 $pharmacy
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pharmacy $pharmacy)
    {
        if ($pharmacy->update($request->all())) {
            return response()->json([
                'message' => 'Pharmacy updated successfully',
                'data' => $pharmacy,
            ], 200);
        }

        return response()->json([
            'message' => 'Pharmacy could not be updated',
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Pharmacy $pharmacy
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pharmacy $pharmacy)
    {
        try {
            $pharmacy->delete();

            return response()->json([
                'message' => 'Pharmacy deleted successfully',
                'data' => $pharmacy,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Returns validation rules for pharmacy resource.
     *
     * @return array
     */
    private function getRules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:pharmacies,email|max:255',
            'phone' => 'required',
            'chief_pharmacist_reg' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
        ];
    }
}
