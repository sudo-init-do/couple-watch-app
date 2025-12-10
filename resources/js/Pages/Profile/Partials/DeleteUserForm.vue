<script setup>
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);
const showPassword = ref(false);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header class="mb-8">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-500 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white">Delete Account</h2>
                    <p class="text-sm text-red-200">Permanently delete your account and all associated data</p>
                </div>
            </div>
        </header>

        <!-- Warning Box -->
        <div class="bg-red-500/10 border-2 border-red-500/30 rounded-2xl p-6">
            <div class="flex items-start space-x-3">
                <svg class="w-6 h-6 text-red-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-red-200 mb-2">Warning: This action is irreversible</h3>
                    <p class="text-sm text-red-200/80 leading-relaxed">
                        Once your account is deleted, all of its resources and data will be permanently deleted. 
                        Before deleting your account, please download any data or information that you wish to retain.
                    </p>
                    <ul class="mt-4 space-y-2 text-sm text-red-200/80">
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <span>All your watch party history will be lost</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <span>All messages and chat history will be deleted</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Your profile information cannot be recovered</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Delete Button -->
        <button
            @click="confirmUserDeletion"
            class="relative group w-full sm:w-auto"
        >
            <div class="absolute -inset-0.5 bg-gradient-to-r from-red-600 to-pink-600 rounded-2xl opacity-75 group-hover:opacity-100 blur transition duration-300 group-hover:blur-lg"></div>
            <div class="relative px-8 py-4 bg-gradient-to-r from-red-600 to-pink-600 rounded-2xl font-bold text-white flex items-center justify-center space-x-2 transition-all duration-300 transform group-hover:scale-[1.02]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                <span>Delete My Account</span>
            </div>
        </button>

        <!-- Confirmation Modal -->
        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-8 bg-gradient-to-br from-gray-900 via-purple-900 to-indigo-900 text-white rounded-3xl">
                <!-- Modal Header -->
                <div class="flex items-start space-x-4 mb-6">
                    <div class="flex-shrink-0 w-14 h-14 bg-red-500/20 rounded-2xl flex items-center justify-center border-2 border-red-500/50">
                        <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-white mb-2">
                            Are you absolutely sure?
                        </h2>
                        <p class="text-purple-200">
                            This action cannot be undone. This will permanently delete your account and remove all your data from our servers.
                        </p>
                    </div>
                </div>

                <!-- Password Input -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-purple-100 mb-2">
                        Please enter your password to confirm
                    </label>
                    <div class="relative">
                        <input
                            id="password"
                            ref="passwordInput"
                            v-model="form.password"
                            :type="showPassword ? 'text' : 'password'"
                            class="w-full px-4 py-4 bg-white/5 border-2 border-white/10 rounded-2xl text-white placeholder-purple-300/50 focus:outline-none focus:border-red-400 focus:shadow-lg focus:shadow-red-500/20 transition-all duration-300"
                            placeholder="Enter your password"
                            @keyup.enter="deleteUser"
                        />
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
                    <p v-if="form.errors.password" class="mt-2 text-sm text-red-300 flex items-center space-x-1 bg-red-500/10 px-3 py-2 rounded-lg">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ form.errors.password }}</span>
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col-reverse sm:flex-row gap-3 sm:justify-end">
                    <button
                        @click="closeModal"
                        class="px-6 py-3 bg-white/10 hover:bg-white/20 border-2 border-white/20 hover:border-white/30 text-white font-semibold rounded-xl transition-all duration-300"
                    >
                        Cancel
                    </button>

                    <button
                        @click="deleteUser"
                        :disabled="form.processing"
                        class="relative group"
                    >
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-red-600 to-pink-600 rounded-xl opacity-75 group-hover:opacity-100 blur transition duration-300"></div>
                        <div class="relative px-6 py-3 bg-gradient-to-r from-red-600 to-pink-600 rounded-xl font-bold text-white flex items-center justify-center space-x-2 transition-all duration-300">
                            <span v-if="!form.processing">Yes, Delete My Account</span>
                            <span v-else class="flex items-center space-x-2">
                                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Deleting...</span>
                            </span>
                        </div>
                    </button>
                </div>
            </div>
        </Modal>
    </section>
</template>
