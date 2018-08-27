<?php

namespace App\Http\Controllers\API\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    //
    public function __construct(){
        $this->doctor = auth('doctor')->user();
    }
    public function show($id){
        $notifications = $this->doctor->notifications;
            return response()->json([
                'message' => 'Marked as read',
                'notifications' => $notifications
            ],200);
    }
    public function delete($id){
        $notification = $this->doctor->notifications()->where('id',$id)->first();
        if ($notification)
        {
            $notification->delete();
            return response()->json([
                'message' => 'Marked as read'
            ],200);
        }
        else return response()->json([
            'message' => 'Something went wrong'
        ],400);
    }

}
