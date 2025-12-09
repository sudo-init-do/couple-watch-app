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
        description: 'Synchronized video playback for you and your partner, no matter the distance.'
    },
    {
        icon: '💬',
        title: 'Real-Time Chat',
        description: 'Share your reactions and thoughts with instant messaging while watching.'
    },
    {
        icon: '🔒',
        title: 'Private Rooms',
        description: 'Create secure, invite-only rooms for intimate viewing experiences.'
    },
    {
        icon: '⚡',
        title: 'Instant Sync',
        description: 'Lightning-fast synchronization keeps everyone perfectly in sync.'
    }
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
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute w-96 h-96 bg-purple-500/20 rounded-full blur-3xl -top-48 -left-48 animate-pulse"></div>
            <div class="absolute w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl -bottom-48 -right-48 animate-pulse" style="animation-delay: 1s"></div>
            <div class="absolute w-64 h-64 bg-pink-500/20 rounded-full blur-3xl top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 animate-pulse" style="animation-delay: 2s"></div>
        </div>

        <!-- Navigation -->
        <nav class="relative z-10 container mx-auto px-6 py-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-2xl font-bold shadow-lg">
                        CW
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                        CoupleWatch
                    </span>
                </div>
                
                <div v-if="canLogin" class="flex items-center space-x-4">
                    <Link
                        :href="route('login')"
                        class="px-6 py-2.5 text-white hover:text-purple-300 transition-colors duration-300 font-medium"
                    >
                        Log in
                    </Link>
                    
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 rounded-lg font-medium shadow-lg hover:shadow-purple-500/50 transition-all duration-300 transform hover:scale-105"
                    >
                        Get Started
                    </Link>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="relative z-10 container mx-auto px-6 pt-20 pb-32">
            <div class="text-center max-w-5xl mx-auto">
                <div 
                    class="transition-all duration-1000 transform"
                    :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                >
                    <h1 class="text-6xl md:text-7xl lg:text-8xl font-bold mb-6 leading-tight">
                        Watch <span class="bg-gradient-to-r from-purple-400 via-pink-400 to-purple-400 bg-clip-text text-transparent animate-gradient">Together</span>,<br/>
                        No Matter the Distance
                    </h1>
                    
                    <p class="text-xl md:text-2xl text-gray-300 mb-12 max-w-3xl mx-auto leading-relaxed">
                        Experience movies and shows together in perfect sync with real-time chat. 
                        Stay connected with your loved ones through the magic of shared moments.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="group px-10 py-4 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 rounded-xl font-bold text-lg shadow-2xl hover:shadow-purple-500/50 transition-all duration-300 transform hover:scale-105 flex items-center space-x-2"
                        >
                            <span>Start Watching Now</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </Link>
                        
                        <button class="px-10 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 rounded-xl font-bold text-lg transition-all duration-300 transform hover:scale-105">
                            See How It Works
                        </button>
                    </div>
                </div>

                <!-- Features Grid -->
                <div 
                    class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mt-24 transition-all duration-1000 delay-300 transform"
                    :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                >
                    <div 
                        v-for="(feature, index) in features" 
                        :key="index"
                        class="group bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:bg-white/10 hover:border-purple-500/50 transition-all duration-300 transform hover:scale-105 hover:-translate-y-2"
                        :style="{ 'animation-delay': `${index * 100}ms` }"
                    >
                        <div class="text-5xl mb-4 group-hover:scale-110 transition-transform duration-300">
                            {{ feature.icon }}
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-white">{{ feature.title }}</h3>
                        <p class="text-gray-400 group-hover:text-gray-300 transition-colors">
                            {{ feature.description }}
                        </p>
                    </div>
                </div>

                <!-- Call to Action -->
                <div 
                    class="mt-32 p-12 bg-gradient-to-r from-purple-600/20 to-pink-600/20 backdrop-blur-sm border border-purple-500/30 rounded-3xl transition-all duration-1000 delay-500 transform"
                    :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                >
                    <h2 class="text-4xl font-bold mb-4">Ready to Connect?</h2>
                    <p class="text-xl text-gray-300 mb-8">
                        Join thousands of couples watching together every day
                    </p>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="inline-block px-12 py-4 bg-white text-purple-900 hover:bg-gray-100 rounded-xl font-bold text-lg shadow-2xl transition-all duration-300 transform hover:scale-105"
                    >
                        Create Your Free Account
                    </Link>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="relative z-10 border-t border-white/10 py-8">
            <div class="container mx-auto px-6 text-center text-gray-400">
                <p>&copy; 2025 CoupleWatch. Made with ❤️ for couples everywhere.</p>
            </div>
        </footer>
    </div>
</template>

<style scoped>
@keyframes gradient {
    0%, 100% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
}

.animate-gradient {
    background-size: 200% auto;
    animation: gradient 3s linear infinite;
}
</style>
