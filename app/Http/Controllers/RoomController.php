<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Room;
use App\Repositories\RoomRepository;
use App\Services\VideoSyncService;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    protected $roomRepository;
    protected $videoSyncService;

    public function __construct(RoomRepository $roomRepository, VideoSyncService $videoSyncService)
    {
        $this->roomRepository = $roomRepository;
        $this->videoSyncService = $videoSyncService;
    }

    public function create()
    {
        return Inertia::render('Room/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'youtube_url' => 'required|url',
        ]);

        // Simple regex to extract ID (improve for prod)
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $request->youtube_url, $matches);
        
        if (!isset($matches[1])) {
            return back()->withErrors(['youtube_url' => 'Invalid YouTube URL']);
        }

        $room = $this->roomRepository->create([
            'youtube_video_id' => $matches[1],
        ], Auth::id());

        return redirect()->route('rooms.show', $room->slug);
    }

    public function show($slug)
    {
        $room = $this->roomRepository->findBySlug($slug);

        if (!$room) {
            abort(404);
        }

        return Inertia::render('Room/Show', [
            'room' => $room,
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request, $slug)
    {
        $room = $this->roomRepository->findBySlug($slug);
        
        if (!$room) {
            abort(404);
        }

        $this->videoSyncService->syncRoom($room, $request->all());

        return response()->json(['status' => 'ok']);
    }
}
