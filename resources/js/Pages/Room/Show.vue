<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import VideoPlayer from '@/Components/Room/VideoPlayer.vue';
import Chat from '@/Components/Room/Chat.vue';
import { ref, onMounted, onBeforeUnmount } from 'vue';
import axios from 'axios';

const props = defineProps({
    room: Object,
    user: Object,
});

const playerRef = ref(null);
const activeUsers = ref([]);
const isSyncing = ref(false);

// Local state to track what we think the player should be doing
const playerState = ref({
    is_playing: props.room.is_playing,
    current_time: props.room.current_time,
    youtube_video_id: props.room.youtube_video_id,
});

const onPlayerReady = () => {
    // Initial seek if needed
    if (playerState.value.current_time > 0) {
        playerRef.value.seekTo(playerState.value.current_time);
    }
};

const handlePlayerStateChange = async (event, time) => {
    if (isSyncing.value) return;

    // Send update to server
    try {
        await axios.post(route('rooms.sync', props.room.slug), {
            is_playing: event === 'play',
            current_time: time,
            youtube_video_id: props.room.youtube_video_id,
        });
    } catch (e) {
        console.error('Sync failed', e);
    }
};

const onPlay = (time) => handlePlayerStateChange('play', time);
const onPause = (time) => handlePlayerStateChange('pause', time);

onMounted(() => {
    window.Echo.join(`room.${props.room.slug}`)
        .here((users) => {
            activeUsers.value = users;
        })
        .joining((user) => {
            activeUsers.value.push(user);
        })
        .leaving((user) => {
            activeUsers.value = activeUsers.value.filter(u => u.id !== user.id);
        })
        .listen('VideoSync', (e) => {
            // Received sync event from server
            isSyncing.value = true;
            
            playerState.value.is_playing = e.room.is_playing;
            
            // Only seek if time difference is significant (> 2 seconds) to avoid jitter
            // But we don't have current player time here easily without querying player.
            // For now, we trust the sync event.
            // Ideally VideoPlayer component handles the "don't seek if close enough" logic or we pass it down.
            // We'll pass the exact time down.
            
            // We update the prop bound to the player
            // But wait, props are immutable. We use a reactive object passed to VideoPlayer? 
            // Or VideoPlayer watches props.
            
            // In VideoPlayer.vue, we watch `isPlaying` and `videoId`.
            // We also need to sync time. VideoPlayer exposes `seekTo`.
            
            if (Math.abs(e.room.current_time - playerState.value.current_time) > 2) {
                 playerRef.value.seekTo(e.room.current_time);
            }
            playerState.value.current_time = e.room.current_time;

            setTimeout(() => { isSyncing.value = false; }, 1000);
        });
});
</script>

<template>
    <Head :title="`Room - ${room.slug}`" />

    <AuthenticatedLayout>
        <div class="h-[calc(100vh-65px)] bg-gray-900 flex flex-col lg:flex-row overflow-hidden">
            <!-- Main Content: Video -->
            <div class="flex-1 flex flex-col p-4 overflow-y-auto">
                <div class="mb-4 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-white">Watching Together</h2>
                    <div class="flex -space-x-2 overflow-hidden">
                        <div v-for="u in activeUsers" :key="u.id" class="inline-block h-8 w-8 rounded-full ring-2 ring-gray-900 bg-indigo-500 flex items-center justify-center text-xs text-white font-bold" :title="u.name">
                            {{ u.name.charAt(0) }}
                        </div>
                    </div>
                </div>
                
                <div class="flex-1 flex items-center justify-center bg-black rounded-xl shadow-2xl overflow-hidden relative">
                    <VideoPlayer
                        ref="playerRef"
                        :video-id="playerState.youtube_video_id"
                        :is-playing="playerState.is_playing"
                        :initial-time="parseFloat(playerState.current_time)"
                        @play="onPlay"
                        @pause="onPause"
                        @ready="onPlayerReady"
                    />
                </div>
                
                <div class="mt-4 text-gray-400 text-sm">
                    <p>Room ID: <span class="text-white font-mono select-all">{{ room.slug }}</span></p>
                    <p>Share this URL to invite friends.</p>
                </div>
            </div>

            <!-- Sidebar: Chat -->
            <div class="w-full lg:w-96 bg-gray-800 border-l border-gray-700 flex flex-col">
                <Chat :room="room" :user="user" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
