<template>
    <auth-layout title="Member Login">
        <el-form @submit.prevent="login(form)">
            <el-form-item label="Email Address" :error="form.errors.email">
                <el-input name="email" placeholder="Email Address" v-model="form.email" />
            </el-form-item>
            <el-form-item label="Password" :error="form.errors.password">
                <el-input toggleMask name="password" type="password" v-model="form.password" show-password />
            </el-form-item>
            <el-form-item>
                <el-button size="default" native-type="submit" class="w-full" :loading="form.processing"> Submit </el-button>
            </el-form-item>
        </el-form>
        <passkey-verify v-if="$page.props.settings['enable_passkeys']" />
    </auth-layout>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import PasskeyVerify from '@/components/passkeys/verify.vue'
import AuthLayout from '@/layouts/auth.vue'
import { ElNotification } from 'element-plus'

// --------------------------------------------------------
// form data
const form = useForm({
    email: '',
    password: '',
    remember: false,
})

// --------------------------------------------------------
// form action
const { login } = useAuth()
</script>
