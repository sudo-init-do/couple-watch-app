<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Message;
use App\Models\Room;
use App\Events\NewMessage;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(Room $room)
    {
        return $room->messages()->with('user')->latest()->take(50)->get()->reverse()->values();
    }

    public function store(Request $request, Room $room)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $message = $room->messages()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        $message->load('user');

        broadcast(new NewMessage($message))->toOthers();

        return $message;
    }
}
