<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const user = ref({
    name: 'Oluwafopohun Deborah Oyeyemi'
});

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <Head title="Dashboard" />

    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-indigo-900 text-white">
        <!-- Custom Navigation -->
        <nav class="border-b border-white/10 backdrop-blur-sm bg-black/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <Link :href="route('dashboard')" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-purple-500/50 transition-all">
                            <span class="text-lg font-bold">CW</span>
                        </div>
                        <span class="text-xl font-bold hidden sm:block">CoupleWatch</span>
                    </Link>

                    <!-- User Menu -->
                    <div class="flex items-center space-x-4">
                        <Link 
                            :href="route('profile.edit')"
                            class="text-sm text-gray-300 hover:text-white transition-colors hidden sm:block"
                        >
                            Profile
                        </Link>
                        <button
                            @click="logout"
                            class="text-sm text-gray-300 hover:text-white transition-colors"
                        >
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
            
            <!-- Hero Section - Simple and Clean -->
            <div class="space-y-6">
                <div>
                    <p class="text-purple-300 text-sm mb-2">Welcome back,</p>
                    <h1 class="text-4xl font-bold">{{ user.name.split(' ')[0] }} 👋</h1>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <Link 
                        :href="route('rooms.create')"
                        class="group inline-flex items-center justify-center space-x-2 px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl font-semibold shadow-lg hover:shadow-xl hover:shadow-purple-500/50 transition-all transform hover:scale-105"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Create Watch Party</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </Link>
                    
                    <button class="inline-flex items-center justify-center space-x-2 px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 rounded-2xl font-semibold transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                        </svg>
                        <span>Invite Friends</span>
                    </button>
                </div>
            </div>

            <!-- Stats - Minimalist -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all">
                    <div class="text-3xl mb-2">🎬</div>
                    <div class="text-3xl font-bold mb-1">0</div>
                    <div class="text-sm text-gray-400">Watch Parties</div>
                </div>
                
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all">
                    <div class="text-3xl mb-2">⏱️</div>
                    <div class="text-3xl font-bold mb-1">0h</div>
                    <div class="text-sm text-gray-400">Hours Watched</div>
                </div>
                
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all">
                    <div class="text-3xl mb-2">💬</div>
                    <div class="text-3xl font-bold mb-1">0</div>
                    <div class="text-sm text-gray-400">Messages</div>
                </div>
                
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all">
                    <div class="text-3xl mb-2">👥</div>
                    <div class="text-3xl font-bold mb-1">0</div>
                    <div class="text-sm text-gray-400">Connections</div>
                </div>
            </div>

            <!-- Main Grid -->
            <div class="grid lg:grid-cols-3 gap-6">
                
                <!-- Recent Activity -->
                <div class="lg:col-span-2 bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold">Recent Activity</h2>
                        <button class="text-sm text-purple-400 hover:text-purple-300">View all</button>
                    </div>
                    
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="text-6xl mb-4">🎬</div>
                        <h3 class="text-xl font-semibold mb-2">No activity yet</h3>
                        <p class="text-gray-400 mb-6">Create your first watch party to get started</p>
                        <Link 
                            :href="route('rooms.create')"
                            class="inline-flex items-center space-x-2 px-6 py-3 bg-purple-600 hover:bg-purple-700 rounded-xl font-medium transition-all"
                        >
                            <span>Create Room</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </Link>
                    </div>
                </div>

                <!-- Quick Start Guide -->
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8">
                    <h2 class="text-2xl font-bold mb-6">Quick Start</h2>
                    
                    <div class="space-y-6">
                        <div class="flex space-x-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center font-bold">
                                1
                            </div>
                            <div>
                                <h3 class="font-semibold mb-1">Create a room</h3>
                                <p class="text-sm text-gray-400">Start with a YouTube link</p>
                            </div>
                        </div>
                        
                        <div class="flex space-x-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-pink-600 rounded-full flex items-center justify-center font-bold">
                                2
                            </div>
                            <div>
                                <h3 class="font-semibold mb-1">Share the link</h3>
                                <p class="text-sm text-gray-400">Invite your partner</p>
                            </div>
                        </div>
                        
                        <div class="flex space-x-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center font-bold">
                                3
                            </div>
                            <div>
                                <h3 class="font-semibold mb-1">Watch together</h3>
                                <p class="text-sm text-gray-400">Synced playback & chat</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-white/10">
                        <div class="text-center">
                            <div class="text-3xl mb-3">💡</div>
                            <h3 class="font-semibold mb-2">Need help?</h3>
                            <p class="text-sm text-gray-400 mb-4">Check our guide</p>
                            <button class="w-full px-4 py-2 bg-white/10 hover:bg-white/20 rounded-xl font-medium transition-all">
                                View Guide
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Overview -->
            <div>
                <h2 class="text-2xl font-bold mb-6">What You Can Do</h2>
                
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="group bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:bg-white/10 hover:border-purple-500/50 transition-all cursor-pointer">
                        <div class="text-4xl mb-4">🎥</div>
                        <h3 class="text-lg font-semibold mb-2">Sync Playback</h3>
                        <p class="text-sm text-gray-400">Watch videos in perfect sync with real-time controls</p>
                    </div>
                    
                    <div class="group bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:bg-white/10 hover:border-purple-500/50 transition-all cursor-pointer">
                        <div class="text-4xl mb-4">💬</div>
                        <h3 class="text-lg font-semibold mb-2">Live Chat</h3>
                        <p class="text-sm text-gray-400">Comment and react while watching together</p>
                    </div>
                    
                    <div class="group bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:bg-white/10 hover:border-purple-500/50 transition-all cursor-pointer">
                        <div class="text-4xl mb-4">🔒</div>
                        <h3 class="text-lg font-semibold mb-2">Private Rooms</h3>
                        <p class="text-sm text-gray-400">Secure, invite-only viewing sessions</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
