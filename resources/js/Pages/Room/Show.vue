<script setup>
import { Head, Link } from '@inertiajs/vue3';
import VideoPlayer from '@/Components/Room/VideoPlayer.vue';
import Chat from '@/Components/Room/Chat.vue';
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

const props = defineProps({
    room: Object,
    user: Object,
});

const playerRef = ref(null);
const activeUsers = ref([]);
const isSyncing = ref(false);
const showShareModal = ref(false);
const copied = ref(false);
const showUsersList = ref(false);

// Local state to track what we think the player should be doing
const playerState = ref({
    is_playing: props.room.is_playing,
    current_time: props.room.current_time,
    youtube_video_id: props.room.youtube_video_id,
});

// Close dropdown when clicking outside
const closeUsersList = () => {
    showUsersList.value = false;
};

const roomUrl = computed(() => {
    return window.location.href;
});

const copyRoomLink = async () => {
    try {
        await navigator.clipboard.writeText(roomUrl.value);
        copied.value = true;
        setTimeout(() => {
            copied.value = false;
        }, 2000);
    } catch (err) {
        console.error('Failed to copy:', err);
    }
};

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
            
            if (Math.abs(e.room.current_time - playerState.value.current_time) > 2) {
                 playerRef.value.seekTo(e.room.current_time);
            }
            playerState.value.current_time = e.room.current_time;

            setTimeout(() => { isSyncing.value = false; }, 1000);
        });
});
</script>

<template>
    <Head :title="`Watch Party - ${room.slug}`" />
    
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-indigo-900 text-white">
        <!-- Animated Background -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute w-96 h-96 bg-purple-500/10 rounded-full blur-3xl -top-48 -left-48 animate-pulse"></div>
            <div class="absolute w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl -bottom-48 -right-48 animate-pulse" style="animation-delay: 1s"></div>
        </div>

        <!-- Top Navigation Bar -->
        <nav class="relative z-10 border-b border-white/10 backdrop-blur-md bg-black/30">
            <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo & Room Info -->
                    <div class="flex items-center space-x-4">
                        <Link :href="route('dashboard')" class="flex items-center space-x-3 group">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-purple-500/50 transition-all">
                                <span class="text-lg font-bold">CW</span>
                            </div>
                            <span class="text-xl font-bold hidden sm:block">CoupleWatch</span>
                        </Link>
                        
                        <div class="hidden md:flex items-center space-x-2 px-4 py-2 bg-white/5 rounded-xl border border-white/10">
                            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-300">Room: <span class="text-white font-mono">{{ room.slug }}</span></span>
                        </div>
                    </div>

                    <!-- Active Users & Actions -->
                    <div class="flex items-center space-x-3">
                        <!-- Active Users -->
                        <div class="relative">
                            <button
                                @click="showUsersList = !showUsersList"
                                class="flex items-center space-x-2 px-4 py-2 bg-white/5 hover:bg-white/10 rounded-xl border border-white/10 hover:border-purple-400/50 transition-all"
                            >
                                <div class="flex -space-x-2">
                                    <div 
                                        v-for="(u, index) in activeUsers.slice(0, 3)" 
                                        :key="u.id" 
                                        class="w-8 h-8 rounded-full ring-2 ring-gray-900 flex items-center justify-center text-xs text-white font-bold"
                                        :class="index === 0 ? 'bg-purple-500' : index === 1 ? 'bg-pink-500' : 'bg-indigo-500'"
                                        :title="u.name"
                                    >
                                        {{ u.name.charAt(0) }}
                                    </div>
                                </div>
                                <span class="text-sm font-medium">{{ activeUsers.length }} watching</span>
                            </button>

                            <!-- Users Dropdown -->
                            <Transition
                                enter-active-class="transition ease-out duration-200"
                                enter-from-class="opacity-0 scale-95"
                                enter-to-class="opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-150"
                                leave-from-class="opacity-100 scale-100"
                                leave-to-class="opacity-0 scale-95"
                            >
                                <div v-if="showUsersList" class="absolute right-0 mt-2 w-64 bg-gray-900 border border-white/20 rounded-2xl shadow-2xl p-4 backdrop-blur-xl">
                                    <h3 class="text-sm font-semibold text-purple-300 mb-3">Watching Now</h3>
                                    <div class="space-y-2 max-h-64 overflow-y-auto">
                                        <div v-for="u in activeUsers" :key="u.id" class="flex items-center space-x-3 p-2 bg-white/5 rounded-lg">
                                            <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-xs font-bold">
                                                {{ u.name.charAt(0) }}
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-white">{{ u.name }}</p>
                                                <p class="text-xs text-gray-400" v-if="u.id === user.id">You</p>
                                            </div>
                                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                        </div>
                                    </div>
                                </div>
                            </Transition>
                        </div>

                        <!-- Share Button -->
                        <button
                            @click="showShareModal = true"
                            class="flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 rounded-xl font-medium shadow-lg shadow-purple-500/30 transition-all"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                            </svg>
                            <span class="hidden sm:inline">Share</span>
                        </button>

                        <!-- Leave Button -->
                        <Link
                            :href="route('dashboard')"
                            class="flex items-center space-x-2 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-red-400/50 text-gray-300 hover:text-white rounded-xl transition-all"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="hidden sm:inline">Leave</span>
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="relative z-10 h-[calc(100vh-4rem)] flex flex-col lg:flex-row">
            <!-- Video Section -->
            <div class="flex-1 flex flex-col p-4 lg:p-6 overflow-hidden">
                <!-- Sync Indicator -->
                <Transition
                    enter-active-class="transition ease-out duration-300"
                    enter-from-class="opacity-0 -translate-y-2"
                    enter-to-class="opacity-100 translate-y-0"
                    leave-active-class="transition ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0"
                    leave-to-class="opacity-0 -translate-y-2"
                >
                    <div v-if="isSyncing" class="mb-4 flex items-center justify-center space-x-2 px-4 py-2 bg-purple-500/20 border border-purple-500/50 rounded-xl backdrop-blur-sm">
                        <svg class="w-5 h-5 text-purple-400 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span class="text-sm font-medium text-purple-200">Syncing playback...</span>
                    </div>
                </Transition>

                <!-- Video Player -->
                <div class="flex-1 relative group">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-pink-600 rounded-3xl opacity-20 group-hover:opacity-30 blur transition duration-500"></div>
                    <div class="relative h-full bg-black rounded-3xl overflow-hidden shadow-2xl border border-white/10">
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
                </div>

                <!-- Room Info (Mobile) -->
                <div class="mt-4 lg:hidden bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-purple-300 mb-1">Room ID</p>
                            <p class="text-sm font-mono text-white">{{ room.slug }}</p>
                        </div>
                        <button
                            @click="copyRoomLink"
                            class="px-4 py-2 bg-purple-600 hover:bg-purple-700 rounded-lg text-sm font-medium transition-colors"
                        >
                            {{ copied ? 'Copied!' : 'Copy Link' }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Chat Sidebar -->
            <div class="w-full lg:w-96 xl:w-[28rem] border-t lg:border-t-0 lg:border-l border-white/10 flex flex-col bg-black/20 backdrop-blur-sm">
                <Chat :room="room" :user="user" />
            </div>
        </div>

        <!-- Share Modal -->
        <Transition
            enter-active-class="transition ease-out duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="showShareModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" @click="showShareModal = false">
                <div class="relative max-w-md w-full" @click.stop>
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-pink-600 rounded-3xl opacity-30 blur"></div>
                    <div class="relative bg-gradient-to-br from-gray-900 via-purple-900 to-indigo-900 rounded-3xl p-8 border border-white/20">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-white">Share Watch Party</h2>
                            <button @click="showShareModal = false" class="text-gray-400 hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <p class="text-purple-200 mb-6">Share this link with your partner to watch together!</p>

                        <div class="bg-white/5 border border-white/10 rounded-2xl p-4 mb-6">
                            <p class="text-xs text-purple-300 mb-2">Room Link</p>
                            <p class="text-sm font-mono text-white break-all">{{ roomUrl }}</p>
                        </div>

                        <button
                            @click="copyRoomLink"
                            class="w-full relative group"
                        >
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl opacity-75 group-hover:opacity-100 blur transition duration-300"></div>
                            <div class="relative px-6 py-4 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl font-bold text-white flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                                </svg>
                                <span>{{ copied ? 'Copied to Clipboard!' : 'Copy Link' }}</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>
