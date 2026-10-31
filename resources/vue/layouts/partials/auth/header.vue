<template>
    <div class="flex flex-col items-center justify-center py-4">
        <Link :href="route('welcome')">
            <img :src="$page.props.settings['logo']" :alt="$page.props.settings['title']" />
        </Link>
    </div>
</template>
