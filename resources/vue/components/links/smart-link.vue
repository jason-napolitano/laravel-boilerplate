<template>
    <component :is="componentType" v-bind="bindings" class="cursor-pointer">
        <slot />
    </component>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { Link } from '@inertiajs/vue3'

// --------------------------------------------------------
// props
interface Props {
    href?: string | null
    method?: Method
    data?: Record<string, any>
    as?: keyof HTMLElementTagNameMap
    onClick?: (event: MouseEvent) => void
}

const props = withDefaults(defineProps<Props>(), {
    href: null,
    method: 'get',
    data: () => ({}),
    as: 'button',
    onClick: undefined,
})

// --------------------------------------------------------
// methods
type Method = 'get' | 'post' | 'put' | 'patch' | 'delete'

// --------------------------------------------------------
// component type
const componentType = computed(() => {
    return props.href ? Link : props.as
})

// --------------------------------------------------------
// build bindings dynamically
const bindings = computed(() => {
    if (props.href) {
        return {
            href: props.href,
            method: props.method,
            data: props.data,
        }
    }

    return {
        onClick: props.onClick,
        type: props.as === 'button' ? 'button' : undefined,
    }
})
</script>
