<template>
    <div class="flex flex-col gap-4">
        <el-alert> Use the form below to manage your profile details. </el-alert>
        <el-form @submit.prevent="submitForm">
            <el-form-item label="Full Name" :error="form.errors.name">
                <el-input name="name" :placeholder="props.user['name']" v-model="form.name" />
            </el-form-item>
            <el-form-item label="Username" :error="form.errors.username">
                <el-input name="username" :placeholder="props.user['username']" v-model="form.username" />
            </el-form-item>
            <el-form-item label="Email Address" :error="form.errors.email">
                <el-input name="email" :placeholder="props.user['email']" v-model="form.email" />
            </el-form-item>
            <el-form-item label="Biography" :error="form.errors.email">
                <el-input name="biography" v-model="form.biography" :placeholder="props.user['biography']" type="textarea" :rows="6" resize="none" />
            </el-form-item>
            <el-form-item>
                <el-button size="default" native-type="submit" class="w-full" :loading="form.processing"> Submit </el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { User } from '@/types'

// --------------------------------------------------------
// props
const props = defineProps<{
    user: User
}>()

// --------------------------------------------------------
// form data
const form = useForm({
    biography: '',
    username: '',
    name: '',
    email: '',
})

const submitForm = () => {
    form.transform((data) => ({
        username: data.username || props.user.username,
        biography: data.biography || props.user.biography,
        name: data.name || props.user.name,
        email: data.email || props.user.email,
    })).patch(route('users.update', props.user), {
        onSuccess: () => {
            ElNotification.success({
                message: 'User successfully updated',
                position: 'bottom-right',
                showClose: false,
            })
            form.reset()
        },
    })
}
</script>
