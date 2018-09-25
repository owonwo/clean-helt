<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Hospital;
use App\Models\Pharmacy;
use App\Models\Laboratory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //
    // Shows the list of all admins with their roles
    public function index()
    {
        $admin = Admin::all();

        return $admin;
    }

    public function store()
    {
        $admin = Admin::forceCreate(request()->all());

        return response()->json([
                'admin' => $admin,
                'message' => 'Admin created Successfully',
            ]);
    }

    public function show(Admin $admin)
    {
        return response()->json([
            'admin' => $admin,
        ]);
    }

    public function update(Admin $admin)
    {
        $admin->update(request()->all());

        return response()->json([
            'message' => 'Admin updated successfully',
            'admin' => $admin,
        ]);
    }

    public function getUsersCount()
    {
        return response()->json([
            'doctors' => Doctor::count(),
            'pharmacies' => Pharmacy::count(),
            'hospitals' => Hospital::count(),
            'patients' => Patient::count(),
            'labs' => Laboratory::count(),
        ]);
    }
}
