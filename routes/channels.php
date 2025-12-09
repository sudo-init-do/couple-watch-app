<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('room.{slug}', function ($user, $slug) {
    return \App\Models\Room::where('slug', $slug)->exists() ? ['id' => $user->id, 'name' => $user->name] : false;
});
