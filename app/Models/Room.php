<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Message;

class Room extends Model
{
    protected $fillable = [
        'slug',
        'youtube_video_id',
        'is_playing',
        'current_time',
        'created_by',
    ];

    protected $casts = [
        'is_playing' => 'boolean',
        'current_time' => 'decimal:2',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
