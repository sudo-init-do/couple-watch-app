<?php

namespace App\Repositories;

use App\Models\Room;
use Illuminate\Support\Str;

class RoomRepository
{
    public function create(array $data, int $userId): Room
    {
        return Room::create([
            'slug' => Str::random(10),
            'youtube_video_id' => $data['youtube_video_id'],
            'created_by' => $userId,
            'is_playing' => false,
            'current_time' => 0,
        ]);
    }

    public function findBySlug(string $slug): ?Room
    {
        return Room::where('slug', $slug)->first();
    }

    public function updateState(Room $room, array $state): Room
    {
        $room->update($state);
        return $room;
    }
}
