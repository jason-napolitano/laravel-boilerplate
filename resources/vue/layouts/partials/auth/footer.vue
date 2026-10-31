<script setup lang="ts"></script>
<template>
    <footer class="flex flex-col items-center justify-center gap-2 pt-4 text-xs text-stone-400/75">
        <ul class="flex gap-2" v-if="$page.props.settings['enable_registration']">
            <li>
                <Link :href="route('login')">Account Login</Link>
            </li>
            <li>
                <Link :href="route('register.index')">Create Account</Link>
            </li>
        </ul>
        <Link v-if="$page.props.settings['enable_reset_password']" :href="route('password.request')">Reset Password</Link>
    </footer>
</template>
