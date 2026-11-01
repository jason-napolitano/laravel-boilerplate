<template>
    <auth-layout>
        <div class="flex flex-col gap-4 text-stone-400">
            <div class="space-y-2 text-center">
                <h1 class="text-lg">Account Verification</h1>
                <h2 class="text-center">Verify your account by entering the six-digit code we sent to your email address</h2>
            </div>

            <div class="flex justify-center">
                <el-form @submit.prevent="submit" label-position="top">
                    <el-form-item :error="form.errors.code">
                        <el-input-otp size="large" v-model="form.code" autofocus class="w-full" />
                    </el-form-item>

                    <el-button native-type="submit" class="w-full" :loading="form.processing" :disabled="form.code.length !== 6" size="default">
                        Verify code
                    </el-button>
                </el-form>
            </div>
        </div>
    </auth-layout>
</template>

<script setup>
import AuthLayout from '@/layouts/auth.vue'

const form = useForm({
    code: '',
})

const submit = () => {
    form.post(route('otp.verify'), {
        onSuccess: () => form.reset(),
    })
}
</script>
