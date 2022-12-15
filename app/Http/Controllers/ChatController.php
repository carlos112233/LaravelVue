<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('chat');
    }

    public function rooms(Request $request)
    {
        return ChatRoom::all();
    }

    public function message(Request $request, $roomId)
    {
        return ChatMessage::where('chat_room_id', $roomId)
            ->with('user')
            ->orderBy('created_at', 'ASC')
            ->get();
    }

    public function newMessage(Request $request, $roomId)
    {
        $newMessage = new ChatMessage();
        $newMessage->user_id = Auth::id();
        $newMessage->chat_room_id = $roomId;
        $newMessage->message = $request->message;
        $newMessage->save();

        return $newMessage;
    }
}
