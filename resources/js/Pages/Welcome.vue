<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});

const features = [
    {
        icon: '🎬',
        title: 'Watch Together',
        description: 'Synchronized video playback for you and your partner, no matter the distance.',
        gradient: 'from-purple-500 to-pink-500'
    },
    {
        icon: '💬',
        title: 'Real-Time Chat',
        description: 'Share your reactions and thoughts with instant messaging while watching.',
        gradient: 'from-pink-500 to-rose-500'
    },
    {
        icon: '🔒',
        title: 'Private Rooms',
        description: 'Create secure, invite-only rooms for intimate viewing experiences.',
        gradient: 'from-indigo-500 to-purple-500'
    },
    {
        icon: '⚡',
        title: 'Instant Sync',
        description: 'Lightning-fast synchronization keeps everyone perfectly in sync.',
        gradient: 'from-violet-500 to-indigo-500'
    }
];

const steps = [
    { number: '1', title: 'Create a Room', description: 'Start a new watch party with a YouTube link' },
    { number: '2', title: 'Share the Link', description: 'Invite your partner with a unique room code' },
    { number: '3', title: 'Watch Together', description: 'Enjoy synchronized playback and chat in real-time' }
];

const isVisible = ref(false);

onMounted(() => {
    setTimeout(() => {
        isVisible.value = true;
    }, 100);
});
</script>

<template>
    <Head title="Welcome to CoupleWatch" />
    
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-indigo-900 text-white overflow-hidden relative">
        <!-- Animated Background -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute w-96 h-96 bg-purple-500/30 rounded-full blur-3xl -top-48 -left-48 animate-pulse"></div>
            <div class="absolute w-96 h-96 bg-indigo-500/30 rounded-full blur-3xl -bottom-48 -right-48 animate-pulse" style="animation-delay: 1s"></div>
            <div class="absolute w-64 h-64 bg-pink-500/20 rounded-full blur-3xl top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 animate-pulse" style="animation-delay: 2s"></div>
        </div>

        <!-- Navigation -->
        <nav class="relative z-10 container mx-auto px-6 py-6">
            <div class="flex justify-between items-center backdrop-blur-sm bg-white/5 rounded-2xl px-6 py-4 border border-white/10">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-xl font-bold shadow-lg shadow-purple-500/50">
                        CW
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-purple-400 via-pink-400 to-purple-400 bg-clip-text text-transparent">
                        CoupleWatch
                    </span>
                </div>
                
                <div v-if="canLogin" class="flex items-center space-x-4">
                    <Link
                        :href="route('login')"
                        class="px-6 py-2.5 text-white hover:text-purple-300 transition-all duration-300 font-medium relative group"
                    >
                        Log in
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-500 to-pink-500 group-hover:w-full transition-all duration-300"></span>
                    </Link>
                    
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 rounded-xl font-medium shadow-lg shadow-purple-500/50 hover:shadow-purple-500/70 transition-all duration-300 transform hover:scale-105"
                    >
                        Get Started
                    </Link>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="relative z-10 container mx-auto px-6 pt-20 pb-16">
            <div class="text-center max-w-6xl mx-auto mb-32">
                <div 
                    class="transition-all duration-1000 transform"
                    :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                >
                    <h1 class="text-6xl md:text-7xl lg:text-8xl font-bold mb-8 leading-tight">
                        Watch <span class="bg-gradient-to-r from-purple-400 via-pink-400 to-purple-400 bg-clip-text text-transparent">Together</span>,<br/>
                        <span class="text-gray-200">No Matter the Distance</span>
                    </h1>
                    
                    <p class="text-xl md:text-2xl text-gray-300 mb-12 max-w-3xl mx-auto leading-relaxed">
                        Experience movies and shows together in perfect sync with real-time chat. 
                        Stay connected with your loved ones through the magic of shared moments.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="group px-10 py-5 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl font-bold text-lg shadow-2xl shadow-purple-500/50 hover:shadow-purple-500/70 transition-all duration-300 transform hover:scale-105 flex items-center space-x-3"
                        >
                            <span>Start Watching Free</span>
                            <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </Link>
                    </div>

                    <!-- Stats -->
                    <div class="flex flex-wrap justify-center gap-8 text-center">
                        <div>
                            <div class="text-4xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">10K+</div>
                            <div class="text-sm text-gray-400 mt-1">Active Users</div>
                        </div>
                        <div>
                            <div class="text-4xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">50K+</div>
                            <div class="text-sm text-gray-400 mt-1">Watch Parties</div>
                        </div>
                        <div>
                            <div class="text-4xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">99.9%</div>
                            <div class="text-sm text-gray-400 mt-1">Sync Accuracy</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="max-w-7xl mx-auto mb-32">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold mb-4">
                        <span class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">Everything You Need</span>
                    </h2>
                    <p class="text-xl text-gray-300">Powerful features to make watching together seamless</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div 
                        v-for="(feature, index) in features" 
                        :key="index"
                        class="group bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 hover:bg-white/10 hover:border-purple-500/50 transition-all duration-500 transform hover:scale-105 hover:-translate-y-3"
                    >
                        <div class="w-16 h-16 bg-gradient-to-br rounded-2xl flex items-center justify-center text-4xl mb-6" :class="feature.gradient">
                            {{ feature.icon }}
                        </div>
                        
                        <h3 class="text-2xl font-bold mb-3 text-white">{{ feature.title }}</h3>
                        <p class="text-gray-400 leading-relaxed">{{ feature.description }}</p>
                    </div>
                </div>
            </div>

            <!-- How It Works -->
            <div class="max-w-5xl mx-auto mb-32">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold mb-4">
                        <span class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">Get Started in 3 Easy Steps</span>
                    </h2>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div v-for="(step, index) in steps" :key="index" class="text-center">
                        <div class="relative inline-flex items-center justify-center w-20 h-20 mb-6">
                            <div class="absolute inset-0 bg-gradient-to-br from-purple-600 to-pink-600 rounded-full animate-pulse"></div>
                            <div class="relative w-16 h-16 bg-gray-900 rounded-full flex items-center justify-center border-4 border-purple-500">
                                <span class="text-2xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                                    {{ step.number }}
                                </span>
                            </div>
                        </div>
                        
                        <h3 class="text-xl font-bold mb-2">{{ step.title }}</h3>
                        <p class="text-gray-400">{{ step.description }}</p>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="max-w-4xl mx-auto">
                <div class="rounded-3xl bg-gradient-to-r from-purple-600/30 to-pink-600/30 backdrop-blur-sm border border-purple-500/50 p-16">
                    <div class="text-center">
                        <h2 class="text-4xl md:text-5xl font-bold mb-4">Ready to Connect?</h2>
                        <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                            Join thousands of couples creating unforgettable moments together
                        </p>
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="inline-block px-12 py-5 bg-white text-purple-900 hover:bg-gray-100 rounded-xl font-bold text-lg shadow-2xl transition-all duration-300 transform hover:scale-105"
                        >
                            Create Your Free Account →
                        </Link>
                        
                        <p class="mt-6 text-sm text-gray-400">
                            No credit card required • Free forever
                        </p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="relative z-10 border-t border-white/10 py-12 mt-20">
            <div class="container mx-auto px-6 text-center text-gray-400">
                <p>&copy; 2025 CoupleWatch. Made with ❤️ for couples everywhere.</p>
            </div>
        </footer>
    </div>
</template>
