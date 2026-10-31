<template>
    <div class="space-y-4">
        <!-- camera -->
        <div v-if="!previewUrl" class="overflow-hidden rounded-lg bg-black">
            <video ref="video" autoplay muted playsinline class="aspect-video w-full object-cover" />
        </div>

        <!-- captured image -->
        <div v-else class="overflow-hidden rounded-lg bg-black">
            <img :src="previewUrl" alt="Captured photo" class="aspect-video w-full object-contain" />
        </div>

        <!-- error -->
        <div v-if="error" class="rounded-lg bg-red-50 p-4 text-sm text-red-700">
            {{ error }}
        </div>

        <!-- camera controls -->
        <div v-if="!previewUrl" class="flex gap-2">
            <button type="button" :disabled="isStarting" @click="startCamera">
                {{ isStarting ? 'Starting...' : 'Start Camera' }}
            </button>
            <button v-if="isCameraActive" type="button" @click="capture">Take Photo</button>
            <button v-if="isCameraActive" type="button" @click="switchCamera">Switch Camera</button>
        </div>

        <!-- preview controls -->
        <div v-else class="flex gap-2">
            <button type="button" @click="retake">Retake</button>
            <button type="button" @click="close">Done</button>
        </div>
    </div>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// events
const emit = defineEmits<{
    captured: [blob: Blob, previewUrl: string]
    closed: []
}>()

// --------------------------------------------------------
// refs
const facingMode = ref<'user' | 'environment'>('environment')
const video = ref<HTMLVideoElement | null>(null)
const stream = ref<MediaStream | null>(null)
const previewUrl = ref<string | null>(null)
const error = ref<string | null>(null)
const isCameraActive = ref(false)
const isStarting = ref(false)

// --------------------------------------------------------
// camera actions
const startCamera = async () => {
    if (isStarting.value) {
        return
    }

    error.value = null
    isStarting.value = true

    try {
        stopCamera()

        stream.value = await navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: facingMode.value,
            },
            audio: false,
        })
        await nextTick()

        if (!video.value) {
            throw new Error('Camera preview is unavailable.')
        }
        video.value.srcObject = stream.value
        await video.value.play()
        isCameraActive.value = true
    } catch (exception) {
        console.error(exception)
        error.value = getCameraError(exception)
        stopCamera()
    } finally {
        isStarting.value = false
    }
}

const stopCamera = () => {
    if (stream.value) {
        stream.value.getTracks().forEach((track) => track.stop())
        stream.value = null
    }
    if (video.value) {
        video.value.srcObject = null
    }
    isCameraActive.value = false
}

const switchCamera = async () => {
    facingMode.value = facingMode.value === 'environment' ? 'user' : 'environment'
    await startCamera()
}

const capture = () => {
    if (!video.value) {
        return
    }

    const width = video.value.videoWidth
    const height = video.value.videoHeight

    if (!width || !height) {
        error.value = 'The camera is not ready yet.'
        return
    }

    const canvas = document.createElement('canvas')

    canvas.width = width
    canvas.height = height

    const context = canvas.getContext('2d')

    if (!context) {
        error.value = 'Unable to capture the camera image.'
        return
    }

    context.drawImage(video.value, 0, 0, width, height)

    canvas.toBlob(
        (blob) => {
            if (!blob) {
                error.value = 'Unable to create the image.'
                return
            }
            if (previewUrl.value) {
                URL.revokeObjectURL(previewUrl.value)
            }

            const url = URL.createObjectURL(blob)
            previewUrl.value = url
            stopCamera()

            emit('captured', blob, url)
        },
        'image/jpeg',
        0.9,
    )
}

const retake = async () => {
    if (previewUrl.value) {
        URL.revokeObjectURL(previewUrl.value)
        previewUrl.value = null
    }
    await startCamera()
}

const close = () => {
    stopCamera()

    if (previewUrl.value) {
        URL.revokeObjectURL(previewUrl.value)
        previewUrl.value = null
    }
    emit('closed')
}

const getCameraError = (exception: unknown): string => {
    if (!(exception instanceof DOMException)) {
        return 'Unable to access the camera.'
    }
    switch (exception.name) {
        case 'NotAllowedError':
            return 'Camera access was denied. Please allow camera access and try again.'
        case 'NotFoundError':
            return 'No camera was found on this device.'
        case 'NotReadableError':
            return 'The camera is already being used by another application.'
        case 'OverconstrainedError':
            return 'The requested camera is not available.'
        case 'SecurityError':
            return 'Camera access is blocked by your browser security settings.'
        default:
            return 'Unable to access the camera.'
    }
}

// --------------------------------------------------------
// lifecycle hooks
onBeforeUnmount(() => {
    stopCamera()
    if (previewUrl.value) {
        URL.revokeObjectURL(previewUrl.value)
    }
})
</script>
