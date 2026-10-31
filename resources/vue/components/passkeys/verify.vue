<template>
    <div class="flex flex-col gap-2">
        <el-button :disabled="!isSupported" :loading="isLoading" @click="verifyPasskey" :icon="UserKey" type="text">
            {{ isLoading ? 'Authenticating...' : 'Passkey Authentication' }}
        </el-button>
        <el-alert type="error" v-if="error" role="alert" v-text="error" />
    </div>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { usePasskeyVerify } from '@laravel/passkeys/vue'
import { UserKey } from 'lucide-vue-next'

// --------------------------------------------------------
// passkey implementation
const { error, isLoading, isSupported } = usePasskeyVerify()
const { verifyPasskey } = usePasskey()
</script>
