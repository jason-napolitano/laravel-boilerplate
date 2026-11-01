<template>
    <div class="flex flex-col items-center justify-center py-4">
        <Link :href="route('welcome')">
            <img :src="$page.props.settings['logo']" :alt="$page.props.settings['title']" v-if="$page.props.settings['logo']" />
            <div v-else>
                <h1 class="text-2xl" v-text="$page.props.settings['title']" />
                <h2 v-text="`v.${$page.props.settings['version']}`" class="text-center" />
            </div>
        </Link>
    </div>
</template>
