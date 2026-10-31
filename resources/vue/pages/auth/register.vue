<template>
    <auth-layout title="Member Registration">
        <el-form @submit.prevent="register(form)">
            <el-form-item label="Full Name" :error="form.errors.name">
                <el-input name="name" placeholder="Full Name" v-model="form.name" />
            </el-form-item>
            <el-form-item label="Username" :error="form.errors.username">
                <el-input name="name" placeholder="Username" v-model="form.username" />
            </el-form-item>
            <el-form-item label="Email Address" :error="form.errors.email">
                <el-input name="email" type="text" placeholder="Email Address" v-model="form.email" />
            </el-form-item>
            <el-form-item label="Password" :error="form.errors.password">
                <el-input name="password" type="password" v-model="form.password" :show-password="true" />
            </el-form-item>
            <el-form-item label="Confirm Password" :error="form.errors.password_confirmation">
                <el-input name="password_confirmation" type="password" v-model="form.password_confirmation" :show-password="true" />
            </el-form-item>
            <el-form-item>
                <el-button size="default" native-type="submit" class="w-full" :loading="form.processing"> Submit </el-button>
            </el-form-item>
        </el-form>
    </auth-layout>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import AuthLayout from '@/layouts/auth.vue'

// --------------------------------------------------------
// form data
const form = useForm({
    username: '',
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

// --------------------------------------------------------
// form action
const { register } = useAuth()
</script>
