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
const activeFeature = ref(0);

onMounted(() => {
    setTimeout(() => {
        isVisible.value = true;
    }, 100);
    
    // Rotate active feature
    setInterval(() => {
        activeFeature.value = (activeFeature.value + 1) % features.length;
    }, 3000);
});
</script>

<template>
    <Head title="Welcome to CoupleWatch" />
    
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-indigo-900 text-white overflow-hidden relative">
        <!-- Animated Background -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Gradient Orbs -->
            <div class="absolute w-[500px] h-[500px] bg-purple-500/30 rounded-full blur-3xl -top-48 -left-48 animate-pulse"></div>
            <div class="absolute w-[500px] h-[500px] bg-indigo-500/30 rounded-full blur-3xl -bottom-48 -right-48 animate-pulse" style="animation-delay: 1s"></div>
            <div class="absolute w-[400px] h-[400px] bg-pink-500/20 rounded-full blur-3xl top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 animate-pulse" style="animation-delay: 2s"></div>
            
            <!-- Floating Particles -->
            <div class="absolute inset-0">
                <div class="particle particle-1"></div>
                <div class="particle particle-2"></div>
                <div class="particle particle-3"></div>
                <div class="particle particle-4"></div>
                <div class="particle particle-5"></div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="relative z-10 container mx-auto px-6 py-6">
            <div class="flex justify-between items-center backdrop-blur-sm bg-white/5 rounded-2xl px-6 py-4 border border-white/10">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-xl font-bold shadow-lg shadow-purple-500/50 animate-glow">
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
                        class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 rounded-xl font-medium shadow-lg shadow-purple-500/50 hover:shadow-purple-500/70 transition-all duration-300 transform hover:scale-105 relative overflow-hidden group"
                    >
                        <span class="relative z-10">Get Started</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-pink-600 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </Link>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="relative z-10 container mx-auto px-6 pt-20 pb-16">
            <!-- Main Hero -->
            <div class="text-center max-w-6xl mx-auto mb-32">
                <div 
                    class="transition-all duration-1000 transform"
                    :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                >
                    <!-- Badge -->
                    <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-6 py-2 mb-8">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-purple-500"></span>
                        </span>
                        <span class="text-sm font-medium">Now with Real-Time Sync</span>
                    </div>

                    <h1 class="text-6xl md:text-7xl lg:text-8xl font-bold mb-8 leading-tight">
                        Watch <span class="relative inline-block">
                            <span class="bg-gradient-to-r from-purple-400 via-pink-400 to-purple-400 bg-clip-text text-transparent animate-gradient">Together</span>
                            <svg class="absolute -bottom-2 left-0 w-full" height="12" viewBox="0 0 200 12" fill="none">
                                <path d="M2 10C50 2 150 2 198 10" stroke="url(#gradient)" stroke-width="3" stroke-linecap="round"/>
                                <defs>
                                    <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%" style="stop-color:rgb(168,85,247);stop-opacity:1" />
                                        <stop offset="50%" style="stop-color:rgb(236,72,153);stop-opacity:1" />
                                        <stop offset="100%" style="stop-color:rgb(168,85,247);stop-opacity:1" />
                                    </linearGradient>
                                </defs>
                            </svg>
                        </span>,<br/>
                        <span class="text-gray-200">No Matter the Distance</span>
                    </h1>
                    
                    <p class="text-xl md:text-2xl text-gray-300 mb-12 max-w-3xl mx-auto leading-relaxed">
                        Experience movies and shows together in perfect sync with real-time chat. 
                        <span class="text-purple-300 font-semibold">Stay connected</span> with your loved ones through the magic of shared moments.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="group relative px-10 py-5 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl font-bold text-lg shadow-2xl shadow-purple-500/50 hover:shadow-purple-500/70 transition-all duration-300 transform hover:scale-105 flex items-center space-x-3 overflow-hidden"
                        >
                            <span class="relative z-10">Start Watching Free</span>
                            <svg class="w-5 h-5 relative z-10 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            <div class="absolute inset-0 bg-gradient-to-r from-pink-600 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl blur opacity-30 group-hover:opacity-50 transition duration-300"></div>
                        </Link>
                        
                        <button class="group px-10 py-5 bg-white/10 hover:bg-white/15 backdrop-blur-sm border-2 border-white/20 hover:border-white/30 rounded-2xl font-bold text-lg transition-all duration-300 transform hover:scale-105 flex items-center space-x-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"></path>
                            </svg>
                            <span>See How It Works</span>
                        </button>
                    </div>

                    <!-- Stats -->
                    <div class="flex flex-wrap justify-center gap-8 text-center">
                        <div class="stat-item">
                            <div class="text-4xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">10K+</div>
                            <div class="text-sm text-gray-400 mt-1">Active Users</div>
                        </div>
                        <div class="stat-item">
                            <div class="text-4xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">50K+</div>
                            <div class="text-sm text-gray-400 mt-1">Watch Parties</div>
                        </div>
                        <div class="stat-item">
                            <div class="text-4xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">99.9%</div>
                            <div class="text-sm text-gray-400 mt-1">Sync Accuracy</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <div class="max-w-7xl mx-auto mb-32">
                <div 
                    class="text-center mb-16 transition-all duration-1000 delay-200 transform"
                    :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                >
                    <h2 class="text-4xl md:text-5xl font-bold mb-4">
                        <span class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">Everything You Need</span>
                    </h2>
                    <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                        Powerful features to make watching together seamless and enjoyable
                    </p>
                </div>

                <div 
                    class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 transition-all duration-1000 delay-300 transform"
                    :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                >
                    <div 
                        v-for="(feature, index) in features" 
                        :key="index"
                        class="group relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 hover:bg-white/10 hover:border-purple-500/50 transition-all duration-500 transform hover:scale-105 hover:-translate-y-3 cursor-pointer"
                        :class="{ 'ring-2 ring-purple-500': index === activeFeature }"
                    >
                        <!-- Glow Effect -->
                        <div class="absolute inset-0 rounded-3xl bg-gradient-to-br opacity-0 group-hover:opacity-20 transition-opacity duration-500" :class="feature.gradient"></div>
                        
                        <!-- Icon -->
                        <div class="relative mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br rounded-2xl flex items-center justify-center text-4xl group-hover:scale-110 transition-transform duration-300 shadow-lg" :class="feature.gradient">
                                {{ feature.icon }}
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <h3 class="text-2xl font-bold mb-3 text-white group-hover:text-purple-300 transition-colors">
                            {{ feature.title }}
                        </h3>
                        <p class="text-gray-400 group-hover:text-gray-300 transition-colors leading-relaxed">
                            {{ feature.description }}
                        </p>

                        <!-- Arrow -->
                        <div class="mt-4 text-purple-400 opacity-0 group-hover:opacity-100 transform translate-x-0 group-hover:translate-x-2 transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- How It Works -->
            <div class="max-w-5xl mx-auto mb-32">
                <div 
                    class="text-center mb-16 transition-all duration-1000 delay-400 transform"
                    :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                >
                    <h2 class="text-4xl md:text-5xl font-bold mb-4">
                        <span class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">Get Started in 3 Easy Steps</span>
                    </h2>
                </div>

                <div class="relative">
                    <!-- Connection Line -->
                    <div class="hidden lg:block absolute top-1/2 left-0 right-0 h-0.5 bg-gradient-to-r from-purple-500 via-pink-500 to-purple-500 -translate-y-1/2"></div>
                    
                    <div class="grid md:grid-cols-3 gap-8 relative">
                        <div 
                            v-for="(step, index) in steps" 
                            :key="index"
                            class="text-center transition-all duration-1000 transform"
                            :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                            :style="{ 'transition-delay': `${500 + index * 100}ms` }"
                        >
                            <!-- Step Number -->
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
            </div>

            <!-- CTA Section -->
            <div 
                class="max-w-4xl mx-auto transition-all duration-1000 delay-600 transform"
                :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
            >
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-purple-600/30 to-pink-600/30 backdrop-blur-sm border border-purple-500/50 p-12 md:p-16">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 1px); background-size: 20px 20px;"></div>
                    </div>
                    
                    <div class="relative text-center">
                        <h2 class="text-4xl md:text-5xl font-bold mb-4">Ready to Connect?</h2>
                        <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                            Join thousands of couples creating unforgettable moments together every day
                        </p>
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="inline-block px-12 py-5 bg-white text-purple-900 hover:bg-gray-100 rounded-xl font-bold text-lg shadow-2xl transition-all duration-300 transform hover:scale-105"
                        >
                            Create Your Free Account →
                        </Link>
                        
                        <p class="mt-6 text-sm text-gray-400">
                            No credit card required • Free forever • Cancel anytime
                        </p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="relative z-10 border-t border-white/10 py-12 mt-20">
            <div class="container mx-auto px-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center space-x-3 mb-4 md:mb-0">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center text-lg font-bold">
                            CW
                        </div>
                        <span class="text-lg font-bold">CoupleWatch</span>
                    </div>
                    <p class="text-gray-400 text-center md:text-right">
                        &copy; 2025 CoupleWatch. Made with <span class="text-pink-500">❤️</span> for couples everywhere.
                    </p>
                </div>
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

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-20px);
    }
}

@keyframes glow {
    0%, 100% {
        box-shadow: 0 0 20px rgba(168, 85, 247, 0.5);
    }
    50% {
        box-shadow: 0 0 30px rgba(236, 72, 153, 0.7);
    }
}

.animate-gradient {
    background-size: 200% auto;
    animation: gradient 3s linear infinite;
}

.animate-glow {
    animation: glow 2s ease-in-out infinite;
}

.particle {
    position: absolute;
    background: radial-gradient(circle, rgba(168, 85, 247, 0.8) 0%, transparent 70%);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
}

.particle-1 {
    width: 4px;
    height: 4px;
    top: 20%;
    left: 20%;
    animation-delay: 0s;
}

.particle-2 {
    width: 6px;
    height: 6px;
    top: 60%;
    left: 80%;
    animation-delay: 1s;
}

.particle-3 {
    width: 3px;
    height: 3px;
    top: 40%;
    left: 40%;
    animation-delay: 2s;
}

.particle-4 {
    width: 5px;
    height: 5px;
    top: 80%;
    left: 60%;
    animation-delay: 3s;
}

.particle-5 {
    width: 4px;
    height: 4px;
    top: 30%;
    left: 70%;
    animation-delay: 4s;
}

.stat-item {
    transition: all 0.3s ease;
}

.stat-item:hover {
    transform: scale(1.1);
}
</style>
