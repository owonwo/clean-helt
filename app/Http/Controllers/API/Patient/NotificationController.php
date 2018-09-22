<?php

namespace App\Http\Controllers\API\Patient;


use App\Http\Controllers\Controller;
use Exception;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:patient-api');
        $this->middleware(function ($request, $next){
            $this->patient = auth()->user();
            return $next($request);
        });
    }

    public function showNotification()
    {
        try {
            $notification = optional($this->patient)->notifications()->paginate(10);

            return response()->json([
                'message' => 'Notification loaded successfully',
                'notification' => $notification,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 403);
        }
    }

    public function unreadNotification()
    {
        try {
            $notification = optional($this->patient)->unreadNotifications()->paginate(10);

            return response()->json([
                'message' => 'Unread notification loaded successfully',
                'notification' => $notification,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 403);
        }
    }

    public function readNotification($id)
    {
        try {
            $notification = optional($this->patient)->notifications()->where('id', $id)->first();

            if($notification) {
                $notification->markAsRead();
                return response()->json([
                    'message' => 'Mark as read',
                    'notification' => $notification
                ], 200);
            } else return response()->json([
                'message' => 'Something went wrong'
            ], 400);
        }catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ],403);
        }

    }

    public function deleteNotification($id)
    {
        try {
            $notification = optional($this->patient)->notifications()->where('id', $id)->first();
            if ($notification) {
                $notification->delete();
                return response()->json([
                    'message' => 'notification deleted'
                ], 200);
            } else return response()->json([
                'message' => 'Something went wrong'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ],403);
        }
    }
}
