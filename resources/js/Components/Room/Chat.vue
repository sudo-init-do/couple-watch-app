<script setup>
import { ref, onMounted, nextTick } from 'vue';
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
const isSending = ref(false);

const fetchMessages = async () => {
    const response = await axios.get(route('rooms.messages.index', props.room.id));
    messages.value = response.data;
    scrollToBottom();
};

const sendMessage = async () => {
    if (!newMessage.value.trim() || isSending.value) return;
    
    const content = newMessage.value;
    newMessage.value = ''; // Optimistic clear
    isSending.value = true;

    try {
        await axios.post(route('rooms.messages.store', props.room.id), {
            content: content
        });
        // Message will be added via Echo listener
    } catch (error) {
        console.error('Failed to send message', error);
        newMessage.value = content; // Restore on failure
    } finally {
        isSending.value = false;
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
    <div class="flex flex-col h-full">
        <!-- Chat Header -->
        <div class="px-6 py-4 border-b border-white/10 bg-gradient-to-r from-purple-900/30 to-pink-900/30 backdrop-blur-sm">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Live Chat</h3>
                    <p class="text-xs text-purple-300">{{ messages.length }} messages</p>
                </div>
            </div>
        </div>
        
        <!-- Messages Container -->
        <div ref="messagesContainer" class="flex-1 overflow-y-auto p-4 space-y-4 scrollbar-thin scrollbar-thumb-purple-500/50 scrollbar-track-transparent">
            <!-- Empty State -->
            <div v-if="messages.length === 0" class="flex flex-col items-center justify-center h-full text-center px-4">
                <div class="w-16 h-16 bg-purple-500/20 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <p class="text-gray-400 text-sm">No messages yet</p>
                <p class="text-gray-500 text-xs mt-1">Be the first to say something!</p>
            </div>

            <!-- Messages -->
            <div v-for="msg in messages" :key="msg.id" class="group">
                <div 
                    class="flex flex-col p-3 rounded-2xl transition-all duration-200"
                    :class="msg.user_id === user.id 
                        ? 'bg-gradient-to-r from-purple-600/20 to-pink-600/20 border border-purple-500/30 ml-4' 
                        : 'bg-white/5 border border-white/10 mr-4 hover:bg-white/10'"
                >
                    <!-- Message Header -->
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center space-x-2">
                            <div 
                                class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold"
                                :class="msg.user_id === user.id 
                                    ? 'bg-gradient-to-br from-purple-500 to-pink-500' 
                                    : 'bg-gradient-to-br from-indigo-500 to-purple-500'"
                            >
                                {{ msg.user.name.charAt(0) }}
                            </div>
                            <span 
                                class="font-semibold text-sm"
                                :class="msg.user_id === user.id ? 'text-purple-300' : 'text-indigo-300'"
                            >
                                {{ msg.user_id === user.id ? 'You' : msg.user.name }}
                            </span>
                        </div>
                        <span class="text-xs text-gray-500">{{ dayjs(msg.created_at).fromNow() }}</span>
                    </div>
                    
                    <!-- Message Content -->
                    <p class="text-gray-200 text-sm leading-relaxed break-words pl-8">{{ msg.content }}</p>
                </div>
            </div>
        </div>

        <!-- Message Input -->
        <div class="p-4 border-t border-white/10 bg-gradient-to-r from-purple-900/20 to-pink-900/20 backdrop-blur-sm">
            <form @submit.prevent="sendMessage" class="space-y-3">
                <div class="relative">
                    <textarea
                        v-model="newMessage"
                        @keydown.enter.exact.prevent="sendMessage"
                        rows="2"
                        placeholder="Type your message... (Enter to send)"
                        class="w-full px-4 py-3 bg-white/5 border-2 border-white/10 rounded-2xl text-white placeholder-purple-300/50 focus:outline-none focus:border-purple-400 focus:shadow-lg focus:shadow-purple-500/20 transition-all duration-300 resize-none"
                    ></textarea>
                    <div class="absolute bottom-3 right-3 text-xs text-gray-500">
                        {{ newMessage.length }}/500
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2 text-xs text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span>Press Enter to send</span>
                    </div>
                    
                    <button 
                        type="submit" 
                        :disabled="!newMessage.trim() || isSending"
                        class="relative group"
                    >
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl opacity-75 group-hover:opacity-100 blur transition duration-300 group-disabled:opacity-30"></div>
                        <div class="relative px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl font-semibold text-white text-sm flex items-center space-x-2 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                            <span v-if="!isSending">Send</span>
                            <span v-else class="flex items-center space-x-2">
                                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Sending...</span>
                            </span>
                            <svg v-if="!isSending" class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>
/* Custom Scrollbar */
.scrollbar-thin::-webkit-scrollbar {
    width: 6px;
}

.scrollbar-thin::-webkit-scrollbar-track {
    background: transparent;
}

.scrollbar-thin::-webkit-scrollbar-thumb {
    background: rgba(168, 85, 247, 0.5);
    border-radius: 3px;
}

.scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background: rgba(168, 85, 247, 0.7);
}
</style>
