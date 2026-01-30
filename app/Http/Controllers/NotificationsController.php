<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{

    public function index(){

   return response()->json([
            'unread_count' => Auth::user()->unreadNotifications->count(),
            'notifications' => Auth::user()->unreadNotifications // Retrieves only unread
        ]);

        
    
    }

    public function markAllRead(){

        Auth::user()->unreadNotifications->markAsRead();

        return redirect()->back();
    }

    public function markAsRead($id){

        $notification = Auth::user()->unreadNotifications->find($id);

        if($notification){
            $notification->markAsRead();
        }

        return response()->json(['status' => 'success']);
    }
}
