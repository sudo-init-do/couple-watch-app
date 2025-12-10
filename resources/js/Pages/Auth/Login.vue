<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const showPassword = ref(false);
const emailFocused = ref(false);
const passwordFocused = ref(false);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log In" />
    
    <div class="min-h-screen bg-gradient-to-br from-purple-900 via-purple-800 to-indigo-900 flex items-center justify-center p-4 relative overflow-hidden">
        <!-- Enhanced Background Effects -->
        <div class="absolute inset-0">
            <!-- Large gradient orbs with better positioning -->
            <div class="absolute w-[800px] h-[800px] bg-purple-500/20 rounded-full blur-3xl -top-64 -left-64 animate-pulse"></div>
            <div class="absolute w-[600px] h-[600px] bg-pink-500/20 rounded-full blur-3xl top-1/3 -right-48 animate-pulse" style="animation-delay: 1.5s"></div>
            <div class="absolute w-[700px] h-[700px] bg-indigo-500/20 rounded-full blur-3xl -bottom-48 left-1/4 animate-pulse" style="animation-delay: 3s"></div>
            
            <!-- Subtle grid pattern -->
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(rgba(255,255,255,0.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.5) 1px, transparent 1px); background-size: 40px 40px;"></div>
        </div>

        <!-- Back to Home - Enhanced -->
        <Link 
            :href="route('welcome')" 
            class="absolute top-6 left-6 z-20 flex items-center space-x-2 text-white/70 hover:text-white transition-all duration-300 group"
        >
            <div class="flex items-center space-x-2 bg-white/10 hover:bg-white/15 backdrop-blur-md px-4 py-2.5 rounded-full border border-white/20 hover:border-white/30 transition-all duration-300">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="text-sm font-medium">Home</span>
            </div>
        </Link>

        <!-- Main Login Card -->
        <div class="relative z-10 w-full max-w-md space-y-8">
            <!-- Logo & Title Section -->
            <div class="text-center space-y-6">
                <!-- Logo with enhanced effects -->
                <div class="flex justify-center">
                    <div class="relative group">
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-500 via-pink-500 to-purple-600 rounded-3xl flex items-center justify-center shadow-2xl shadow-purple-500/50 transform transition-all duration-500 group-hover:scale-110 group-hover:rotate-3">
                            <span class="text-3xl font-black text-white">CW</span>
                        </div>
                        <!-- Animated glow ring -->
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-pink-600 rounded-3xl blur-xl opacity-50 group-hover:opacity-75 transition-opacity duration-500 -z-10"></div>
                    </div>
                </div>

                <!-- Title -->
                <div class="space-y-3">
                    <h1 class="text-4xl md:text-5xl font-bold text-white">
                        Welcome Back! 
                        <span class="inline-block animate-wave">👋</span>
                    </h1>
                    <p class="text-lg text-purple-200">
                        Sign in to continue your watch party
                    </p>
                </div>
            </div>

            <!-- Form Card with enhanced design -->
            <div class="relative group">
                <!-- Animated border glow -->
                <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-pink-600 rounded-3xl opacity-20 group-hover:opacity-30 blur transition duration-500"></div>
                
                <!-- Main card -->
                <div class="relative backdrop-blur-xl bg-white/10 rounded-3xl shadow-2xl border border-white/20 p-8 space-y-6">
                    <!-- Status Message -->
                    <div v-if="status" class="p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl backdrop-blur-sm">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-emerald-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <p class="text-sm text-emerald-200 font-medium">{{ status }}</p>
                        </div>
                    </div>

                    <form @submit.prevent="submit" class="space-y-5">
                        <!-- Email Field -->
                        <div class="space-y-2">
                            <label for="email" class="flex items-center space-x-2 text-sm font-semibold text-purple-100">
                                <svg class="w-4 h-4 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                                <span>Email Address</span>
                            </label>
                            <div class="relative">
                                <input
                                    id="email"
                                    v-model="form.email"
                                    @focus="emailFocused = true"
                                    @blur="emailFocused = false"
                                    type="email"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    class="w-full px-4 py-4 bg-white/5 border-2 rounded-2xl text-white placeholder-purple-300/50 focus:outline-none transition-all duration-300"
                                    :class="emailFocused || form.email ? 'border-purple-400 shadow-lg shadow-purple-500/20' : 'border-white/10'"
                                    placeholder="your@email.com"
                                />
                                <!-- Icon -->
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 transition-all duration-300" :class="emailFocused ? 'text-purple-400 scale-110' : 'text-purple-300/30'">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p v-if="form.errors.email" class="text-sm text-red-300 flex items-center space-x-1 bg-red-500/10 px-3 py-2 rounded-lg">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ form.errors.email }}</span>
                            </p>
                        </div>

                        <!-- Password Field -->
                        <div class="space-y-2">
                            <label for="password" class="flex items-center space-x-2 text-sm font-semibold text-purple-100">
                                <svg class="w-4 h-4 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span>Password</span>
                            </label>
                            <div class="relative">
                                <input
                                    id="password"
                                    v-model="form.password"
                                    @focus="passwordFocused = true"
                                    @blur="passwordFocused = false"
                                    :type="showPassword ? 'text' : 'password'"
                                    required
                                    autocomplete="current-password"
                                    class="w-full px-4 py-4 bg-white/5 border-2 rounded-2xl text-white placeholder-purple-300/50 focus:outline-none transition-all duration-300"
                                    :class="passwordFocused || form.password ? 'border-purple-400 shadow-lg shadow-purple-500/20' : 'border-white/10'"
                                    placeholder="Enter your password"
                                />
                                <!-- Toggle visibility button -->
                                <button
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-purple-300/70 hover:text-purple-200 transition-colors p-1"
                                >
                                    <svg v-if="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                    </svg>
                                </button>
                            </div>
                            <p v-if="form.errors.password" class="text-sm text-red-300 flex items-center space-x-1 bg-red-500/10 px-3 py-2 rounded-lg">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ form.errors.password }}</span>
                            </p>
                        </div>

                        <!-- Remember & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <input
                                    type="checkbox"
                                    v-model="form.remember"
                                    class="w-5 h-5 rounded-lg border-2 border-white/20 bg-white/5 text-purple-600 focus:ring-2 focus:ring-purple-500 focus:ring-offset-0 transition-all cursor-pointer"
                                />
                                <span class="text-sm text-purple-100 group-hover:text-white transition-colors">Remember me</span>
                            </label>

                            <Link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="text-sm text-purple-300 hover:text-purple-200 transition-colors font-medium"
                            >
                                Forgot password?
                            </Link>
                        </div>

                        <!-- Sign In Button -->
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="relative w-full group"
                        >
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl opacity-75 group-hover:opacity-100 blur transition duration-300 group-hover:blur-lg"></div>
                            <div class="relative px-6 py-4 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl font-bold text-white text-lg flex items-center justify-center space-x-2 transition-all duration-300 transform group-hover:scale-[1.02]">
                                <span v-if="!form.processing">Sign In to CoupleWatch</span>
                                <span v-else class="flex items-center space-x-2">
                                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span>Signing you in...</span>
                                </span>
                                <svg v-if="!form.processing" class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </div>
                        </button>

                        <!-- Divider -->
                        <div class="relative py-4">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-white/10"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 text-purple-300 bg-transparent">Don't have an account?</span>
                            </div>
                        </div>

                        <!-- Create Account Button -->
                        <Link 
                            :href="route('register')" 
                            class="block w-full py-4 px-6 bg-white/5 hover:bg-white/10 border-2 border-white/20 hover:border-purple-400/50 text-white font-semibold rounded-2xl transition-all duration-300 text-center group"
                        >
                            <span class="flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5 text-purple-300 group-hover:text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                <span>Create New Account</span>
                            </span>
                        </Link>
                    </form>
                </div>
            </div>

            <!-- Trust Indicators -->
            <div class="flex items-center justify-center space-x-8 text-sm">
                <div class="flex items-center space-x-2 text-purple-200">
                    <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Secure Login</span>
                </div>
                <div class="flex items-center space-x-2 text-purple-200">
                    <svg class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                    </svg>
                    <span>24/7 Support</span>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes wave {
    0%, 100% {
        transform: rotate(0deg);
    }
    25% {
        transform: rotate(20deg);
    }
    75% {
        transform: rotate(-20deg);
    }
}

.animate-wave {
    display: inline-block;
    animation: wave 2s ease-in-out infinite;
}
</style>
