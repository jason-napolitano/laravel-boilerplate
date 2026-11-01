<template>
    <div class="flex min-h-screen items-center justify-center px-4">
        <div class="w-full max-w-md space-y-6">
            <div class="space-y-2 text-center">
                <h1 class="text-2xl font-semibold">Verify your email</h1>

                <p class="text-gray-500">We've sent a six-digit verification code to your email address.</p>
            </div>

            <el-form @submit.prevent="submit" label-position="top">
                <el-form-item label="Verification code" :error="form.errors.code">
                    <el-input
                        v-model="form.code"
                        maxlength="6"
                        inputmode="numeric"
                        autocomplete="one-time-code"
                        placeholder="000000"
                        size="large"
                        autofocus
                    />
                </el-form-item>

                <el-button
                    type="primary"
                    native-type="submit"
                    size="large"
                    class="w-full"
                    :loading="form.processing"
                    :disabled="form.code.length !== 6"
                >
                    Verify code
                </el-button>
            </el-form>

            <div class="text-center text-sm text-gray-500">
                Didn't receive the code?
                <a :href="route('login')" class="text-primary-600 hover:underline"> Return to login </a>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    code: '',
})

const submit = () => {
    form.post(route('otp.verify'), {
        onSuccess: () => form.reset(),
    })
}
</script>
