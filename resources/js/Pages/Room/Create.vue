<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const form = useForm({
    youtube_url: '',
});

const urlFocused = ref(false);
const showPreview = ref(false);

// Extract video ID from YouTube URL
const videoId = computed(() => {
    if (!form.youtube_url) return null;
    
    const patterns = [
        /(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\s]+)/,
        /youtube\.com\/embed\/([^&\s]+)/,
    ];
    
    for (const pattern of patterns) {
        const match = form.youtube_url.match(pattern);
        if (match) return match[1];
    }
    return null;
});

const thumbnailUrl = computed(() => {
    if (!videoId.value) return null;
    return `https://img.youtube.com/vi/${videoId.value}/maxresdefault.jpg`;
});

const submit = () => {
    form.post(route('rooms.store'));
};

const popularVideos = [
    { title: 'Lofi Hip Hop', url: 'https://www.youtube.com/watch?v=jfKfPfyJRdk' },
    { title: 'Nature Documentary', url: 'https://www.youtube.com/watch?v=enu-qR0H_uk' },
    { title: 'Movie Trailer', url: 'https://www.youtube.com/watch?v=dQw4w9WgXcQ' },
];

const useExample = (url) => {
    form.youtube_url = url;
    showPreview.value = true;
};
</script>

<template>
    <Head title="Create Watch Party" />
    
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-indigo-900 text-white">
        <!-- Animated Background -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute w-96 h-96 bg-purple-500/20 rounded-full blur-3xl -top-48 -left-48 animate-pulse"></div>
            <div class="absolute w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl -bottom-48 -right-48 animate-pulse" style="animation-delay: 1s"></div>
            <div class="absolute w-64 h-64 bg-pink-500/10 rounded-full blur-3xl top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 animate-pulse" style="animation-delay: 2s"></div>
        </div>

        <!-- Navigation -->
        <nav class="relative z-10 border-b border-white/10 backdrop-blur-sm bg-black/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <Link :href="route('dashboard')" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-purple-500/50 transition-all">
                            <span class="text-lg font-bold">CW</span>
                        </div>
                        <span class="text-xl font-bold hidden sm:block">CoupleWatch</span>
                    </Link>

                    <!-- Back to Dashboard -->
                    <Link 
                        :href="route('dashboard')" 
                        class="flex items-center space-x-2 text-gray-300 hover:text-white transition-colors group"
                    >
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="text-sm font-medium">Back to Dashboard</span>
                    </Link>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Header -->
            <div class="mb-12 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-3xl shadow-2xl shadow-purple-500/50 mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    Create a <span class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">Watch Party</span>
                </h1>
                <p class="text-xl text-gray-300">Share a YouTube video and watch together in perfect sync</p>
            </div>

            <!-- Main Form Card -->
            <div class="relative group mb-8">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-pink-600 rounded-3xl opacity-20 group-hover:opacity-30 blur transition duration-500"></div>
                <div class="relative backdrop-blur-xl bg-white/10 rounded-3xl shadow-2xl border border-white/20 p-8">
                    <form @submit.prevent="submit" class="space-y-8">
                        <!-- YouTube URL Input -->
                        <div class="space-y-3">
                            <label for="youtube_url" class="flex items-center space-x-2 text-lg font-semibold text-purple-100">
                                <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                                <span>YouTube Video URL</span>
                            </label>
                            <div class="relative">
                                <input
                                    id="youtube_url"
                                    v-model="form.youtube_url"
                                    @focus="urlFocused = true"
                                    @blur="urlFocused = false"
                                    @input="showPreview = !!videoId"
                                    type="url"
                                    required
                                    class="w-full px-6 py-5 bg-white/5 border-2 rounded-2xl text-white text-lg placeholder-purple-300/50 focus:outline-none transition-all duration-300"
                                    :class="urlFocused || form.youtube_url ? 'border-purple-400 shadow-lg shadow-purple-500/20' : 'border-white/10'"
                                    placeholder="https://www.youtube.com/watch?v=..."
                                />
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 transition-all duration-300" :class="urlFocused ? 'text-purple-400 scale-110' : 'text-purple-300/30'">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                </div>
                            </div>
                            <p v-if="form.errors.youtube_url" class="text-sm text-red-300 flex items-center space-x-1 bg-red-500/10 px-4 py-3 rounded-xl">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ form.errors.youtube_url }}</span>
                            </p>
                            <p class="text-sm text-purple-200/70 flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Paste any YouTube video URL to get started</span>
                            </p>
                        </div>

                        <!-- Video Preview -->
                        <Transition
                            enter-active-class="transition ease-out duration-300"
                            enter-from-class="opacity-0 scale-95"
                            enter-to-class="opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-200"
                            leave-from-class="opacity-100 scale-100"
                            leave-to-class="opacity-0 scale-95"
                        >
                            <div v-if="showPreview && videoId" class="bg-white/5 border border-white/10 rounded-2xl p-6">
                                <div class="flex items-center space-x-3 mb-4">
                                    <div class="w-10 h-10 bg-green-500/20 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-white">Video Preview</h3>
                                        <p class="text-sm text-gray-400">Your video is ready to share</p>
                                    </div>
                                </div>
                                <div class="aspect-video bg-black rounded-xl overflow-hidden">
                                    <img 
                                        v-if="thumbnailUrl" 
                                        :src="thumbnailUrl" 
                                        alt="Video thumbnail"
                                        class="w-full h-full object-cover"
                                    />
                                </div>
                            </div>
                        </Transition>

                        <!-- Submit Button -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center pt-4">
                            <button
                                type="submit"
                                :disabled="form.processing || !form.youtube_url"
                                class="relative group w-full sm:w-auto"
                            >
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl opacity-75 group-hover:opacity-100 blur transition duration-300 group-hover:blur-lg"></div>
                                <div class="relative px-12 py-5 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl font-bold text-white text-lg flex items-center justify-center space-x-3 transition-all duration-300 transform group-hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span v-if="!form.processing">Create Watch Party</span>
                                    <span v-else class="flex items-center space-x-2">
                                        <svg class="animate-spin h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span>Creating Room...</span>
                                    </span>
                                    <svg v-if="!form.processing" class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Examples -->
            <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center space-x-2">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span>Quick Start Examples</span>
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <button
                        v-for="(video, index) in popularVideos"
                        :key="index"
                        @click="useExample(video.url)"
                        type="button"
                        class="px-4 py-3 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-purple-400/50 rounded-xl text-left transition-all group"
                    >
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center group-hover:bg-purple-500/30 transition-colors">
                                <svg class="w-4 h-4 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-300 group-hover:text-white transition-colors">{{ video.title }}</span>
                        </div>
                    </button>
                </div>
            </div>

            <!-- How It Works -->
            <div class="mt-12 grid md:grid-cols-3 gap-6">
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 text-center hover:bg-white/10 transition-all">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold">1</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Paste URL</h3>
                    <p class="text-sm text-gray-400">Copy any YouTube video link and paste it above</p>
                </div>
                
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 text-center hover:bg-white/10 transition-all">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold">2</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Share Link</h3>
                    <p class="text-sm text-gray-400">Get a unique room link to share with your partner</p>
                </div>
                
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 text-center hover:bg-white/10 transition-all">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold">3</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Watch Together</h3>
                    <p class="text-sm text-gray-400">Enjoy synchronized playback and real-time chat</p>
                </div>
            </div>
        </div>
    </div>
</template>
