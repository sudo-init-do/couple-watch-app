<script setup>
import { ref, onMounted, nextTick, watch } from 'vue';
import axios from 'axios';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

dayjs.extend(relativeTime);

const props = defineProps({
    room: Object,
    user: Object,
});

const messages = ref([]);
const newMessage = ref('');
const messagesContainer = ref(null);

const fetchMessages = async () => {
    const response = await axios.get(route('rooms.messages.index', props.room.id));
    messages.value = response.data;
    scrollToBottom();
};

const sendMessage = async () => {
    if (!newMessage.value.trim()) return;
    
    const content = newMessage.value;
    newMessage.value = ''; // Optimistic clear

    try {
        await axios.post(route('rooms.messages.store', props.room.id), {
            content: content
        });
        // Message will be added via Echo listener
    } catch (error) {
        console.error('Failed to send message', error);
        // Restore message on failure?
    }
};

const scrollToBottom = () => {
    nextTick(() => {
        if (messagesContainer.value) {
            messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
        }
    });
};

onMounted(() => {
    fetchMessages();

    window.Echo.join(`room.${props.room.slug}`)
        .listen('NewMessage', (e) => {
            messages.value.push(e.message);
            scrollToBottom();
        });
});
</script>

<template>
    <div class="flex flex-col h-full bg-gray-800 rounded-lg shadow-xl overflow-hidden border border-gray-700">
        <div class="p-4 bg-gray-900 border-b border-gray-700">
            <h3 class="text-lg font-semibold text-white">Chat</h3>
        </div>
        
        <div ref="messagesContainer" class="flex-1 overflow-y-auto p-4 space-y-4">
            <div v-for="msg in messages" :key="msg.id" class="flex flex-col">
                <div class="flex items-baseline space-x-2">
                    <span class="font-bold text-sm" :class="msg.user_id === user.id ? 'text-indigo-400' : 'text-emerald-400'">
                        {{ msg.user.name }}
                    </span>
                    <span class="text-xs text-gray-500">{{ dayjs(msg.created_at).fromNow() }}</span>
                </div>
                <p class="text-gray-300 text-sm mt-1 break-words">{{ msg.content }}</p>
            </div>
        </div>

        <div class="p-4 bg-gray-900 border-t border-gray-700">
            <form @submit.prevent="sendMessage" class="flex gap-2">
                <input 
                    v-model="newMessage" 
                    type="text" 
                    placeholder="Type a message..." 
                    class="flex-1 bg-gray-800 border-gray-700 text-white rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                >
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors disabled:opacity-50"
                    :disabled="!newMessage.trim()"
                >
                    Send
                </button>
            </form>
        </div>
    </div>
</template>
