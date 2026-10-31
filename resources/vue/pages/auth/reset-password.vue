<template>
    <auth-layout title="Forgot Password">
        <el-form @submit.prevent="resetPassword(form)">
            <el-form-item label="Email Address" :error="form.errors.email" hidden>
                <el-input v-model="form.email" />
            </el-form-item>

            <el-form-item label="New Password" :error="form.errors.password">
                <el-input v-model="form.password" type="password" show-password />
            </el-form-item>

            <el-form-item label="Confirm New Password" :error="form.errors.password_confirmation">
                <el-input v-model="form.password_confirmation" type="password" show-password />
            </el-form-item>

            <el-form-item>
                <el-button native-type="submit" :loading="form.processing" class="w-full">Submit</el-button>
            </el-form-item>
        </el-form>
    </auth-layout>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import AuthLayout from '@/layouts/auth.vue'
import { ElNotification } from 'element-plus'

// --------------------------------------------------------
// props
interface PageProps {
    token: string
    email: string
}

const props = defineProps<PageProps>()

// --------------------------------------------------------
// form data
const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
})

// --------------------------------------------------------
// form action
const { resetPassword } = useAuth()
</script>

<style scoped>
/* --- */
</style>
