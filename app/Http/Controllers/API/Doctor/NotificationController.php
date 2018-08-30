<?php

namespace App\Http\Controllers\API\Doctor;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function __construct()
    {
    }

    public function show()
    {
        $doctor = auth()->guard('doctor-api')->user();
        $notifications = $doctor->notifications;

        return response()->json([
                'message' => 'Notifications Loaded successfully',
                'notifications' => $notifications,
            ], 200);
    }

    public function delete($id)
    {
        $doctor = auth()->guard('doctor-api')->user();
        $notification = $doctor->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->delete();

            return response()->json([
                'message' => 'Marked as read',
            ], 200);
        } else {
            return response()->json([
            'message' => 'Something went wrong',
        ], 400);
        }
    }
}
