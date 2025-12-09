<script setup>
import { ref, onMounted, watch, onBeforeUnmount } from 'vue';
import { useScriptTag } from '@vueuse/core';

const props = defineProps({
    videoId: {
        type: String,
        required: true,
    },
    initialTime: {
        type: Number,
        default: 0,
    },
    isPlaying: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['play', 'pause', 'seek', 'ready', 'state-change']);

const playerElement = ref(null);
const player = ref(null);
const isPlayerReady = ref(false);
const internalUpdate = ref(false); // To prevent loops

// Load YouTube API
useScriptTag(
    'https://www.youtube.com/iframe_api',
    () => {
        // API loaded, wait for onYouTubeIframeAPIReady if needed, 
        // but useScriptTag usually handles the script load. 
        // We need to ensure YT.Player is available.
        initPlayer();
    }
);

// Global callback for YouTube API
window.onYouTubeIframeAPIReady = () => {
    initPlayer();
};

const initPlayer = () => {
    if (player.value || !window.YT) return;

    player.value = new window.YT.Player(playerElement.value, {
        height: '100%',
        width: '100%',
        videoId: props.videoId,
        playerVars: {
            'playsinline': 1,
            'controls': 1,
            'rel': 0,
            'start': Math.floor(props.initialTime),
        },
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange,
        },
    });
};

const onPlayerReady = (event) => {
    isPlayerReady.value = true;
    emit('ready');
    if (props.isPlaying) {
        player.value.playVideo();
    }
};

const onPlayerStateChange = (event) => {
    if (internalUpdate.value) return;

    // YT.PlayerState: -1 (unstarted), 0 (ended), 1 (playing), 2 (paused), 3 (buffering), 5 (cued)
    const state = event.data;
    const currentTime = player.value.getCurrentTime();

    if (state === window.YT.PlayerState.PLAYING) {
        emit('play', currentTime);
    } else if (state === window.YT.PlayerState.PAUSED) {
        emit('pause', currentTime);
    }
    
    // Seek detection is tricky with standard API events, usually inferred from time jumps
    // But for basic sync, play/pause + periodic time checks or explicit syncs work.
};

// Watch for prop changes from server/peers
watch(() => props.isPlaying, (newVal) => {
    if (!isPlayerReady.value) return;
    internalUpdate.value = true;
    if (newVal) {
        player.value.playVideo();
    } else {
        player.value.pauseVideo();
    }
    setTimeout(() => { internalUpdate.value = false; }, 500);
});

watch(() => props.videoId, (newVal) => {
    if (!isPlayerReady.value) return;
    player.value.loadVideoById(newVal);
});

// Expose seek method
const seekTo = (time) => {
    if (!isPlayerReady.value) return;
    internalUpdate.value = true;
    player.value.seekTo(time, true);
    setTimeout(() => { internalUpdate.value = false; }, 500);
};

defineExpose({ seekTo });

</script>

<template>
    <div class="aspect-video w-full bg-black rounded-lg overflow-hidden shadow-xl">
        <div ref="playerElement"></div>
    </div>
</template>
