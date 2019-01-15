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
    public static $rules = [
        'name' => 'required|string|min:3',
        'email' => 'required|email|string',
        'password' => 'required|string|confirmed',
    ];

    // Shows the list of all admins with their roles
    public function index()
    {
        $admin = Admin::all();

        return $admin;
    }

    public function store()
    {
        request()->validate(static::$rules);
        extract(request()->all());

        $name = ucfirst($name);
        $password = bcrypt($password);

        $admin = Admin::forceCreate(compact('name', 'email', 'password'));

        return response()->json(
            [
                'admin' => $admin,
                'message' => 'Admin created Successfully',
            ]
        );
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

    /**
     * Disables an admin
     *
     * @param admin App\Models\Admin  The Admin Model
     *
     * @author Joseph Julius
     **/
    public function disable(Admin $admin)
    {
        $admin->active = 0;
        $message = $admin->name . ' disabled';

        return $admin->save()
            ? response()->json(compact('message'))
            : response()->json(['message' => 'Can\'t Disable' . $admin->name], 400);
    }

    /**
     * Enables an admin
     *
     * @param admin App\Models\Admin  The Admin Model
     *
     * @author Joseph Julius
     **/
    public function enable(Admin $admin)
    {
        $admin->active = 1;
        $message = $admin->name . ' Enabled';

        return $admin->save()
            ? response()->json(compact('message'))
            : response()->json(['message' => 'Can\'t Enable ' . $admin->name], 400);
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
