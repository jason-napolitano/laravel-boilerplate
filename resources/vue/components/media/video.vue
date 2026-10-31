<template>
    <div data-vjs-player>
        <video ref="videoEl" class="video-js vjs-default-skin" controls />
    </div>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import 'video.js/dist/video-js.css'

// --------------------------------------------------------
// props
interface VideoSource {
    src: string
    type: string
}

interface Props {
    options: {
        sources: VideoSource[]
        responsive: boolean
        autoplay: boolean
        controls: boolean
        fluid: boolean
    }
}

const props = defineProps<Props>()

// --------------------------------------------------------
// events
const emit = defineEmits<{
    (e: 'play'): void
    (e: 'pause'): void
    (e: 'ended'): void
    (e: 'error'): void
    (e: 'timeupdate', currentTime: number): void
    (e: 'loadedmetadata', duration: number): void
}>()

// --------------------------------------------------------
// video element
const videoEl = ref<HTMLVideoElement | null>(null)
let player = null

// --------------------------------------------------------
// lifecycle hooks
onMounted(async () => {
    // auto-import video.js
    const videojs = (await import('video.js')).default

    // assign the player
    if (videoEl.value) {
        player = videojs(videoEl.value, props.options)
    }

    // player events
    if (player) {
        player.on('play', () => emit('play'))
        player.on('pause', () => emit('pause'))
        player.on('ended', () => emit('ended'))
        player.on('error', () => emit('error'))

        player.on('timeupdate', () => {
            emit('timeupdate', player!.currentTime())
        })

        player.on('loadedmetadata', () => {
            emit('loadedmetadata', player!.duration())
        })
    }
})

onBeforeUnmount(() => {
    if (player) {
        player.dispose()
        player = null
    }
})

// --------------------------------------------------------
// watchers
watch(
    () => props.options.sources,
    (newSources) => {
        if (player && newSources) {
            player.src(newSources)
        }
    },
    { deep: true },
)
</script>

<style scoped>
.video-js {
    width: 100%;
    height: auto;
}
</style>
