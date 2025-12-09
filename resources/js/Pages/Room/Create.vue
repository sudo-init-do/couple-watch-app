<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    youtube_url: '',
});

const submit = () => {
    form.post(route('rooms.store'));
};
</script>

<template>
    <Head title="Create Room" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create a Room</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="submit" class="space-y-6 max-w-xl mx-auto">
                            <div>
                                <label for="youtube_url" class="block text-sm font-medium text-gray-300">YouTube URL</label>
                                <input 
                                    id="youtube_url" 
                                    v-model="form.youtube_url" 
                                    type="text" 
                                    class="mt-1 block w-full bg-gray-900 border-gray-700 text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="https://www.youtube.com/watch?v=..."
                                    required
                                >
                                <p v-if="form.errors.youtube_url" class="mt-2 text-sm text-red-400">{{ form.errors.youtube_url }}</p>
                            </div>

                            <div class="flex justify-end">
                                <button 
                                    type="submit" 
                                    class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    :disabled="form.processing"
                                >
                                    Create Room
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
