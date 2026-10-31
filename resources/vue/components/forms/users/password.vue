<template>
    <div class="flex flex-col gap-4">
        <el-alert> Use the form below to manage your security details. </el-alert>
        <el-form @submit.prevent="submit">
            <el-form-item label="Password" :error="form.errors.password">
                <el-input name="password" type="password" v-model="form.password" />
            </el-form-item>
            <el-form-item label="Confirm Password" :error="form.errors.password_confirmation">
                <el-input name="password_confirmation" type="password" v-model="form.password_confirmation" />
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
    password: '',
    password_confirmation: '',
})

// --------------------------------------------------------
// form actions
const submit = () => {
    form.patch(route('users.update', props.user), {
        onSuccess: () => {
            ElNotification.success({
                message: 'Password successfully updated',
                position: 'bottom-right',
                showClose: false,
            })
            form.reset()
        },
    })
}
</script>
