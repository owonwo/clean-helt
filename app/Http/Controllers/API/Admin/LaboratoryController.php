<?php

namespace App\Http\Controllers\API\Admin;

use Validator;
use App\Http\Controllers\Controller;
use App\Models\Laboratory;
use Illuminate\Http\Request;

class LaboratoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:admin-api');
    }

    public function index()
    {
        $labs = Laboratory::latest()->paginate(15);

        return response()->json([
            'data' => $labs,
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
        $rules = [
            'name' => 'required|string|max:190',
            'licence_no' => 'required|string|max:190|unique:laboratories',
            'email' => 'required|string|max:190|unique:laboratories',
            'phone' => 'required|unique:laboratories',
        ];

        $validator = Validator::make($request->all(), $rules);

        if (!$validator->fails()) {
            $data = $request->all();

            $password = str_random(10);
            $data['password'] = bcrypt($password);
            $data['avatar'] = 'public/defaults/avatars/provider.png';

            if ($labs = Laboratory::create($data)) {
                return response()->json([
                    'message' => 'Laboratory created successfully ',
                ], 200);
            }
        }

        return response()->json(['errors' => $validator->errors()], 422);
    }

    public function deactivate(Laboratory $laboratory)
    {
        $laboratory->update([
            'active' => true == $laboratory->active ? false : true,
        ]);

        return response()->json([
            'data' => $laboratory,
            'message' => 'Active changed',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Laboratory $laboratory)
    {
        return response()->json(
            ['message' => 'Laboratory fetched successfully',
            'data' => $laboratory,
            ],
            200
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Laboratory $laboratory)
    {
        if ($laboratory->update($request->all())) {
            return response()->json([
                'message' => 'Laboratory updated successfully ',
                'data' => $laboratory,
            ], 200);
        }

        return response()->json([
            'message' => 'All data were submitted',
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Laboratory $laboratory)
    {
        try {
            $laboratory->delete();

            return response()->json([
                'message' => 'Laboratory was successfully deleted ',
                'data' => $laboratory,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
