<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});

const nameFocused = ref(false);
const emailFocused = ref(false);
</script>

<template>
    <section>
        <header class="mb-8">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white">Profile Information</h2>
                    <p class="text-sm text-purple-200">Update your account's profile information and email address</p>
                </div>
            </div>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="space-y-6">
            <!-- Name Field -->
            <div class="space-y-2">
                <label for="name" class="flex items-center space-x-2 text-sm font-semibold text-purple-100">
                    <svg class="w-4 h-4 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Full Name</span>
                </label>
                <div class="relative">
                    <input
                        id="name"
                        v-model="form.name"
                        @focus="nameFocused = true"
                        @blur="nameFocused = false"
                        type="text"
                        required
                        autofocus
                        autocomplete="name"
                        class="w-full px-4 py-4 bg-white/5 border-2 rounded-2xl text-white placeholder-purple-300/50 focus:outline-none transition-all duration-300"
                        :class="nameFocused || form.name ? 'border-purple-400 shadow-lg shadow-purple-500/20' : 'border-white/10'"
                        placeholder="Enter your full name"
                    />
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 transition-all duration-300" :class="nameFocused ? 'text-purple-400 scale-110' : 'text-purple-300/30'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <p v-if="form.errors.name" class="text-sm text-red-300 flex items-center space-x-1 bg-red-500/10 px-3 py-2 rounded-lg">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ form.errors.name }}</span>
                </p>
            </div>

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
                        autocomplete="username"
                        class="w-full px-4 py-4 bg-white/5 border-2 rounded-2xl text-white placeholder-purple-300/50 focus:outline-none transition-all duration-300"
                        :class="emailFocused || form.email ? 'border-purple-400 shadow-lg shadow-purple-500/20' : 'border-white/10'"
                        placeholder="your@email.com"
                    />
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

            <!-- Email Verification Notice -->
            <div v-if="mustVerifyEmail && user.email_verified_at === null" class="bg-yellow-500/10 border border-yellow-500/30 rounded-2xl p-4">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-yellow-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm text-yellow-200 font-medium">Your email address is unverified.</p>
                        <Link
                            :href="route('verification.send')"
                            method="post"
                            as="button"
                            class="mt-2 text-sm text-yellow-300 hover:text-yellow-200 underline font-medium transition-colors"
                        >
                            Click here to re-send the verification email.
                        </Link>
                        <div
                            v-show="status === 'verification-link-sent'"
                            class="mt-2 text-sm font-medium text-green-300 flex items-center space-x-1"
                        >
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>A new verification link has been sent to your email address.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center gap-4 pt-4">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="relative group"
                >
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl opacity-75 group-hover:opacity-100 blur transition duration-300 group-hover:blur-lg"></div>
                    <div class="relative px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl font-bold text-white flex items-center justify-center space-x-2 transition-all duration-300 transform group-hover:scale-[1.02]">
                        <span v-if="!form.processing">Save Changes</span>
                        <span v-else class="flex items-center space-x-2">
                            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Saving...</span>
                        </span>
                        <svg v-if="!form.processing" class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </button>

                <Transition
                    enter-active-class="transition ease-in-out duration-300"
                    enter-from-class="opacity-0 scale-90"
                    enter-to-class="opacity-100 scale-100"
                    leave-active-class="transition ease-in-out duration-300"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-90"
                >
                    <div
                        v-if="form.recentlySuccessful"
                        class="flex items-center space-x-2 text-emerald-300 bg-emerald-500/10 px-4 py-2 rounded-xl border border-emerald-500/30"
                    >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-medium">Saved successfully!</span>
                    </div>
                </Transition>
            </div>
        </form>
    </section>
</template>
