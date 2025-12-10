<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const activeTab = ref('profile');
</script>

<template>
    <Head title="Profile Settings" />
    
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
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Header -->
            <div class="mb-12 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-3xl shadow-2xl shadow-purple-500/50 mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    Profile <span class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">Settings</span>
                </h1>
                <p class="text-xl text-gray-300">Manage your account and preferences</p>
            </div>

            <!-- Tab Navigation -->
            <div class="flex justify-center mb-8">
                <div class="inline-flex bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-1.5">
                    <button
                        @click="activeTab = 'profile'"
                        :class="activeTab === 'profile' 
                            ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg' 
                            : 'text-gray-300 hover:text-white'"
                        class="px-6 py-3 rounded-xl font-medium transition-all duration-300 flex items-center space-x-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Profile Info</span>
                    </button>
                    <button
                        @click="activeTab = 'password'"
                        :class="activeTab === 'password' 
                            ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg' 
                            : 'text-gray-300 hover:text-white'"
                        class="px-6 py-3 rounded-xl font-medium transition-all duration-300 flex items-center space-x-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span>Security</span>
                    </button>
                    <button
                        @click="activeTab = 'danger'"
                        :class="activeTab === 'danger' 
                            ? 'bg-gradient-to-r from-red-600 to-pink-600 text-white shadow-lg' 
                            : 'text-gray-300 hover:text-white'"
                        class="px-6 py-3 rounded-xl font-medium transition-all duration-300 flex items-center space-x-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span>Danger Zone</span>
                    </button>
                </div>
            </div>

            <!-- Content Cards -->
            <div class="max-w-4xl mx-auto">
                <!-- Profile Information -->
                <div v-show="activeTab === 'profile'" class="relative group">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-pink-600 rounded-3xl opacity-20 group-hover:opacity-30 blur transition duration-500"></div>
                    <div class="relative backdrop-blur-xl bg-white/10 rounded-3xl shadow-2xl border border-white/20 p-8">
                        <UpdateProfileInformationForm
                            :must-verify-email="mustVerifyEmail"
                            :status="status"
                        />
                    </div>
                </div>

                <!-- Update Password -->
                <div v-show="activeTab === 'password'" class="relative group">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-pink-600 rounded-3xl opacity-20 group-hover:opacity-30 blur transition duration-500"></div>
                    <div class="relative backdrop-blur-xl bg-white/10 rounded-3xl shadow-2xl border border-white/20 p-8">
                        <UpdatePasswordForm />
                    </div>
                </div>

                <!-- Delete Account -->
                <div v-show="activeTab === 'danger'" class="relative group">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-red-600 to-pink-600 rounded-3xl opacity-20 group-hover:opacity-30 blur transition duration-500"></div>
                    <div class="relative backdrop-blur-xl bg-white/10 rounded-3xl shadow-2xl border border-white/20 p-8">
                        <DeleteUserForm />
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="max-w-4xl mx-auto mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 text-center hover:bg-white/10 transition-all">
                    <div class="text-3xl mb-2">🎬</div>
                    <div class="text-2xl font-bold mb-1">0</div>
                    <div class="text-sm text-gray-400">Watch Parties Created</div>
                </div>
                
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 text-center hover:bg-white/10 transition-all">
                    <div class="text-3xl mb-2">⏱️</div>
                    <div class="text-2xl font-bold mb-1">0h</div>
                    <div class="text-sm text-gray-400">Total Watch Time</div>
                </div>
                
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 text-center hover:bg-white/10 transition-all">
                    <div class="text-3xl mb-2">💬</div>
                    <div class="text-2xl font-bold mb-1">0</div>
                    <div class="text-sm text-gray-400">Messages Sent</div>
                </div>
            </div>
        </div>
    </div>
</template>
