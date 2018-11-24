<?php

namespace App\Http\Controllers\API\Doctor;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor-api');
    }

    public function show()
    {
        $doctor = auth()->guard('doctor-api')->user();

        try {
            $notifications = optional($doctor)->notifications()
                ->paginate(20);

            return response()->json([
                'message' => 'Notifications Loaded successfully',
                'notifications' => $notifications,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 403);
        }
    }

    public function delete($id)
    {
        $doctor = auth()->guard('doctor-api')->user();
        try {
            $notification = optional($doctor)->notifications()->where('id', $id)->first();
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
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 403);
        }
    }
}
