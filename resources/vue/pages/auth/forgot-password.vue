<template>
    <auth-layout title="Forgot Password">
        <div class="flex flex-col gap-4">
            <p class="mt-2 text-gray-600">Enter your email address and we'll send you a password reset link.</p>
            <el-form @submit.prevent="forgotPassword(form.email)">
                <el-form-item label="Email Address" :error="form.errors.email">
                    <el-input v-model="form.email" />
                </el-form-item>

                <el-form-item>
                    <el-button native-type="submit" :loading="form.processing" class="w-full">Submit</el-button>
                </el-form-item>
            </el-form>
        </div>
    </auth-layout>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import AuthLayout from '@/layouts/auth.vue'
import { ElNotification } from 'element-plus'

// --------------------------------------------------------
// form data
const form = useForm({
    email: '',
})

// --------------------------------------------------------
// form action
const { forgotPassword } = useAuth()
</script>
