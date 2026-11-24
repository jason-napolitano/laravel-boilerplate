<template>
    <div class="flex gap-1">
        <span role="button" tabindex="0" @click="copy" @keydown.enter.prevent="copy" @keydown.space.prevent="copy" class="cursor-pointer">
            <component v-if="icon" :is="icon" class="h-4" />
        </span>

        <slot v-if="text === undefined" />

        <template v-else>
            {{ text }}
        </template>
    </div>
</template>

<script setup lang="ts">
import { computed, ref, useSlots, type FunctionalComponent } from 'vue'

interface Props {
    text?: string
    icon?: FunctionalComponent
}

const props = defineProps<Props>()

const emit = defineEmits<{
    copied: [text: string]
    error: [error: unknown]
}>()

const slots = useSlots()

const copied = ref(false)
const copying = ref(false)

const content = computed(() => {
    if (props.text !== undefined) {
        return props.text
    }

    return (
        slots
            .default?.()
            .map((node) => {
                if (typeof node.children === 'string') {
                    return node.children
                }

                return ''
            })
            .join('')
            .trim() ?? ''
    )
})

async function copy() {
    if (copying.value || !content.value) return

    copying.value = true

    try {
        await navigator.clipboard.writeText(content.value)

        copied.value = true
        emit('copied', content.value)

        if (copied.value) {
            ElMessage({
                message: 'Copied to clipboard',
                placement: 'bottom-right',
                type: 'success',
                plain: true,
            })
        }

        setTimeout(() => {
            copied.value = false
        }, 2000)
    } catch (error) {
        emit('error', error)

        ElMessage({
            message: 'Error copying to clipboard',
            placement: 'bottom-right',
            type: 'error',
            plain: true,
        })
    } finally {
        copying.value = false
    }
}
</script>
