<?php

namespace App\Services;

use App\Events\VideoSync;
use App\Repositories\RoomRepository;
use App\Models\Room;

class VideoSyncService
{
    protected $roomRepository;

    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    public function syncRoom(Room $room, array $data)
    {
        // Update room state in DB
        $updatedRoom = $this->roomRepository->updateState($room, [
            'is_playing' => $data['is_playing'] ?? $room->is_playing,
            'current_time' => $data['current_time'] ?? $room->current_time,
            'youtube_video_id' => $data['youtube_video_id'] ?? $room->youtube_video_id,
        ]);

        // Broadcast event
        broadcast(new VideoSync($updatedRoom))->toOthers();

        return $updatedRoom;
    }
}
