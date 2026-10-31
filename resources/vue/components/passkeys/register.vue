<template>
    <el-button @click="toggleDialog" :disabled="!isCurrentUser(props.user)" :icon="UserKey">Register Passkey</el-button>

    <el-dialog v-model="dialogOpen" width="350" title="Register Passkey">
        <div class="flex flex-col gap-2">
            <el-form @submit.prevent="registerPasskey($event, toggleDialog)" class="space-y-3">
                <el-form-item label="Name">
                    <el-input id="passkey-name" v-model="passkeyName" placeholder="My Windows PC" />
                </el-form-item>

                <el-button native-type="submit" :loading="isLoading" class="w-full">
                    {{ isLoading ? 'Registering...' : 'Add passkey' }}
                </el-button>
            </el-form>

            <el-alert v-if="error" role="alert">
                {{ error }}
            </el-alert>
        </div>
    </el-dialog>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { usePasskeyRegister } from '@laravel/passkeys/vue'
import { UserKey } from 'lucide-vue-next'
import { User } from '@/types'

// --------------------------------------------------------
// props
const props = defineProps<{
    user: User
}>()

// --------------------------------------------------------
// auth check
const { isCurrentUser } = useAuth()

// --------------------------------------------------------
// dialog window
const { dialogOpen, toggleDialog } = useDialog()

// --------------------------------------------------------
// passkey implementation
const { isLoading, error, isSupported } = usePasskeyRegister()
const { passkeyName, registerPasskey } = usePasskey()
</script>
