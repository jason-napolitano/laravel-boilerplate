<template>
    <master-layout :title="props.title">
        <div class="flex h-screen bg-white text-zinc-600 dark:bg-stone-800">
            <sidebar />
            <div class="flex flex-1 flex-col">
                <topbar />
                <main class="flex-1 justify-between gap-2 overflow-y-auto bg-[#F5F7FA] p-4 pl-2 dark:bg-stone-950">
                    <header class="flex items-center">
                        <slot name="header" />
                    </header>
                    <section
                        class="ml-3 border border-stone-200 bg-white p-4 text-stone-500/90 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-100"
                    >
                        <div class="mb-4 flex items-center justify-between border-b border-stone-200 pb-4 dark:border-stone-600">
                            <slot name="headingLeft">
                                <h1 class="text-lg">{{ props.title }}</h1>
                            </slot>
                            <slot name="headingRight" />
                        </div>
                        <content>
                            <slot />
                        </content>
                    </section>
                </main>
            </div>
        </div>
    </master-layout>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import Content from './partials/dashboard/content.vue'
import Sidebar from './partials/dashboard/sidebar.vue'
import Topbar from './partials/dashboard/topbar.vue'
import MasterLayout from '@/layouts/master.vue'

// --------------------------------------------------------
// props
interface AppLayoutProps {
    title?: string
    card?: boolean
}
const props = withDefaults(defineProps<AppLayoutProps>(), {
    breadcrumbs: null,
    title: null,
    card: true,
})
</script>
