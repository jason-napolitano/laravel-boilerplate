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
            <div class="space-y-3 text-center">
                <p v-if="message" class="text-sm text-green-600">
                    {{ message }}
                </p>

                <p v-if="resendForm.errors.resend" class="text-sm text-red-500">
                    {{ resendForm.errors.resend }}
                </p>

                <el-button link type="primary" :disabled="countdown > 0 || resendForm.processing" :loading="resendForm.processing" @click="resend">
                    <template v-if="countdown > 0"> Resend code in {{ countdown }}s </template>

                    <template v-else> Resend verification code </template>
                </el-button>
            </div>
        </div>
    </auth-layout>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import AuthLayout from '@/layouts/auth.vue'

// --------------------------------------------------------
// props
const props = withDefaults(
    defineProps<{
        resendAvailableIn: number
    }>(),
    {
        resendAvailableIn: 60,
    },
)

// --------------------------------------------------------
// form data
const resendForm = useForm({})
const form = useForm({
    code: '',
})

// --------------------------------------------------------
// form actions
const submit = () => {
    form.post(route('otp.verify'), {
        onSuccess: () => form.reset(),
    })
}

// --------------------------------------------------------
// resend message / countdown
const countdown = ref(props.resendAvailableIn)
const message = ref('')
let timer = null

const startCountdown = () => {
    clearInterval(timer)

    timer = setInterval(() => {
        if (countdown.value > 0) {
            countdown.value--
        } else {
            clearInterval(timer)
        }
    }, 1000)
}
const resend = () => {
    if (countdown.value > 0 || resendForm.processing) {
        return
    }

    message.value = ''

    resendForm.post(route('otp.resend'), {
        preserveScroll: true,

        onSuccess: () => {
            countdown.value = 60
            message.value = 'A new verification code has been sent.'
            form.clearErrors('code')
            startCountdown()
        },
    })
}

onMounted(startCountdown)

onUnmounted(() => {
    clearInterval(timer)
})
</script>
