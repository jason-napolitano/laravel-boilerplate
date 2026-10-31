<template>
    <div class="flex flex-col gap-2">
        <button class="relative h-80 w-full overflow-hidden" :disabled="uploading" type="button">
            <lightbox :image-class="props.imageClass" :lightbox="props.lightbox" :alt="props.altText" v-if="imageUrl" :src="imageUrl" />

            <!-- No image placeholder -->
            <span
                class="flex h-full w-full flex-col items-center justify-center bg-gray-200 text-gray-500 dark:bg-stone-700 dark:text-gray-200"
                v-else
            >
                <ImageOff />
                <span v-text="props.unavailableText" />
            </span>

            <!-- Upload overlay -->
            <span v-if="uploading" class="absolute inset-0 flex items-center justify-center bg-black/50">
                <svg class="h-6 w-6 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />

                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                </svg>
            </span>
        </button>

        <div>
            <!-- Hidden file input -->
            <input v-if="props.canUpdate" ref="fileInput" type="file" accept="image/jpeg,image/png" class="hidden" @change="upload" />

            <el-button-group class="w-full">
                <el-button v-if="props.canUpdate" size="default" :class="[canDelete ? 'w-5/6' : 'w-full']" @click="selectFile" :icon="Image">
                    {{ props.buttonText }}
                </el-button>
                <el-button
                    :class="[props.canDelete ? 'w-1/6' : '']"
                    v-if="props.canDelete"
                    :disabled="!imageUrl"
                    @click="deleteImage"
                    :icon="Trash2"
                    size="default"
                    type="danger"
                />
            </el-button-group>
        </div>
    </div>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import Lightbox from '@/components/media/lightbox.vue'
import { Image, Trash2, ImageOff } from 'lucide-vue-next'
import { DatabaseRecord } from '@/types'
import { router } from '@inertiajs/vue3'

// --------------------------------------------------------
// props
interface Props {
    unavailableText?: string
    model: DatabaseRecord
    deleteRoute?: string
    imageClass?: string
    uploadRoute: string
    buttonText?: string
    canUpdate?: boolean
    canDelete?: boolean
    lightbox?: boolean
    altText?: string
    border?: boolean
    column?: string
    field?: string
}

const props = withDefaults(defineProps<Props>(), {
    buttonText: 'Upload Image',
    unavailableText: null,
    deleteRoute: null,
    canDelete: true,
    canUpdate: true,
    lightbox: true,
    imageClass: '',
    column: 'image',
    border: true,
    altText: null,
    field: 'image',
})

// --------------------------------------------------------
// events
const emit = defineEmits<{
    uploaded: [url: string]
}>()

// --------------------------------------------------------
// uploader
const fileInput = ref<HTMLInputElement | null>(null)
const previewUrl = ref<string | null>(null)
const uploading = ref<boolean>(false)

// Used to force the browser to reload the image
const cacheKey = ref(Date.now())

const imageUrl = computed(() => {
    // While uploading, show the local preview immediately
    if (previewUrl.value) {
        return previewUrl.value
    }

    if (!props.model[props.column]) {
        return null
    }

    // Cache busting
    return `${props.model[props.column]}?v=${cacheKey.value}`
})

function selectFile() {
    if (uploading.value) {
        return
    }

    fileInput.value?.click()
}

function upload(event: Event) {
    const input = event.target as HTMLInputElement
    const file = input.files?.[0]

    if (!file) {
        return
    }

    // Immediately display the image the model selected
    previewUrl.value = URL.createObjectURL(file)

    uploading.value = true

    const formData = new FormData()
    formData.append(props.field, file)

    router.post(route(props.uploadRoute, props.model), formData, {
        forceFormData: true,
        preserveScroll: true,

        onSuccess: () => {
            // The server has successfully saved the image
            cacheKey.value = Date.now()

            // Remove the temporary local preview
            if (previewUrl.value) {
                URL.revokeObjectURL(previewUrl.value)
                previewUrl.value = null
            }

            // Notify the parent if it needs to update other state
            emit('uploaded', props.model[props.column] ?? '')
        },

        onError: () => {
            // Upload failed, so remove the temporary preview
            if (previewUrl.value) {
                URL.revokeObjectURL(previewUrl.value)
                previewUrl.value = null
            }
        },

        onFinish: () => {
            uploading.value = false

            // Reset the input so selecting the same file again
            // will trigger @change
            input.value = ''
        },
    })
}

// --------------------------------------------------------
// delete image
const deleteImage = () => {
    ElMessageBox.confirm('Are you sure you want to delete the image?', 'Continue?', {
        type: 'warning',
    }).then(() => {
        router.delete(route(props.deleteRoute, props.model), {
            onStart: () => {
                uploading.value = true
            },
            onSuccess: () => {
                uploading.value = false
            },
        })
    })
}

// --------------------------------------------------------
// lifecycle hooks
onBeforeUnmount(() => {
    if (previewUrl.value) {
        URL.revokeObjectURL(previewUrl.value)
    }
})
</script>
