<template>
    <!-- Main Image -->
    <img :src="src" :alt="alt" :class="[props.imageClass, props.lightbox ? 'cursor-zoom-in' : '']" @click="openLightbox" />

    <!-- Lightbox -->
    <Teleport to="body">
        <Transition name="fade">
            <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4" @click.self="closeLightbox">
                <!-- Close Button -->
                <button
                    class="absolute top-5 right-5 cursor-pointer text-3xl text-white hover:text-gray-300"
                    aria-label="Close lightbox"
                    @click="closeLightbox"
                    type="button"
                >
                    &times;
                </button>

                <!-- Full Image -->
                <img :src="src" :alt="alt" class="max-h-[90vh] max-w-full object-contain shadow-2xl" />
            </div>
        </Transition>
    </Teleport>
</template>

<script setup lang="ts">
interface LightboxProps {
    src: string
    alt?: string
    lightbox?: boolean
    imageUrl?: string
    imageClass?: string
}

const props = withDefaults(defineProps<LightboxProps>(), {
    imageClass: 'w-full h-auto',
    lightbox: true,
    alt: '',
})

const isOpen = ref(false)

const openLightbox = () => {
    if (props.lightbox) {
        isOpen.value = true
    }
}

const closeLightbox = () => {
    isOpen.value = false
}

const handleKeydown = (event) => {
    if (event.key === 'Escape') {
        closeLightbox()
    }
}

watch(isOpen, (open) => {
    document.body.style.overflow = open ? 'hidden' : ''
})

onMounted(() => {
    window.addEventListener('keydown', handleKeydown)
})

onUnmounted(() => {
    window.removeEventListener('keydown', handleKeydown)
    document.body.style.overflow = ''
})
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
