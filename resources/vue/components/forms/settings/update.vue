<template>
    <el-form @submit.prevent="updateSettings">
        <h1 class="mb-4 border-b border-stone-200 pb-2 text-lg dark:border-stone-600">Authentication Settings</h1>
        <el-row>
            <el-col :span="6">
                <el-form-item label="Password Reset">
                    <el-select v-model="form.enable_reset_password" :disabled="cannot('enable_password_reset_settings')">
                        <el-option v-for="option in dropdownOptions" :value="option.value" :key="option.value" :label="option.label" />
                    </el-select>
                </el-form-item>
            </el-col>
            <el-col :span="6">
                <el-form-item label="User Registration">
                    <el-select v-model="form.enable_registration" :disabled="cannot('enable_registration_settings')">
                        <el-option v-for="option in dropdownOptions" :value="option.value" :key="option.value" :label="option.label" />
                    </el-select>
                </el-form-item>
            </el-col>
            <el-col :span="6">
                <el-form-item label="Passkey Support">
                    <el-select v-model="form.enable_passkeys" :disabled="cannot('enable_passkeys_settings')">
                        <el-option v-for="option in dropdownOptions" :value="option.value" :key="option.value" :label="option.label" />
                    </el-select>
                </el-form-item>
            </el-col>
            <el-col :span="6">
                <el-form-item label="OTP Support" :error="form.errors.enable_otp_support">
                    <el-select v-model="form.enable_otp_support" :disabled="cannot('enable_one_time_passwords')">
                        <el-option v-for="option in dropdownOptions" :value="option.value" :key="option.value" :label="option.label" />
                    </el-select>
                </el-form-item>
            </el-col>
        </el-row>

        <h1 class="mb-2 border-b border-stone-200 pb-2 text-lg dark:border-stone-600">Application Settings</h1>
        <el-row>
            <el-col :span="8">
                <el-form-item label="Application Title" :error="form.errors.title">
                    <el-input v-model="form.title" :placeholder="props.settings.title" :disabled="cannot('update_app_title')" />
                </el-form-item>
            </el-col>
            <el-col :span="8">
                <el-form-item label="Application Version" :error="form.errors.version">
                    <el-input v-model="form.version" :placeholder="props.settings.version" :disabled="cannot('update_app_version')" />
                </el-form-item>
            </el-col>

            <el-col :span="8">
                <el-form-item label="Items Per Page">
                    <el-select v-model="form.items_per_page" :disabled="cannot('update_items_per_page')">
                        <el-option v-for="option in itemsOptions" :value="option" :label="option" />
                    </el-select>
                </el-form-item>
            </el-col>
        </el-row>

        <el-form-item label="Application Description" :error="form.errors.description">
            <el-input
                :disabled="cannot('update_app_description')"
                :placeholder="props.settings.description"
                v-model="form.description"
                type="textarea"
                resize="none"
                :rows="4"
            />
        </el-form-item>

        <el-form-item>
            <el-button size="default" native-type="submit" class="w-full" :loading="form.processing"> Submit </el-button>
        </el-form-item>
    </el-form>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { Settings } from '@/types'

// --------------------------------------------------------
// component props
const props = defineProps<{
    settings: Settings
}>()

// --------------------------------------------------------
// auth check
const { cannot } = useAuth()

// --------------------------------------------------------
// form options
const itemsOptions = [5, 10, 15, 20, 25, 50]

const dropdownOptions = [
    { label: 'Enabled', value: true },
    { label: 'Disabled', value: false },
]

// --------------------------------------------------------
// form data
const form = useForm({
    title: props.settings.title,
    version: props.settings.version,
    description: props.settings.description,
    items_per_page: props.settings.items_per_page,
    enable_passkeys: props.settings.enable_passkeys,
    enable_otp_support: props.settings.enable_otp_support,
    enable_registration: props.settings.enable_registration,
    enable_reset_password: props.settings.enable_reset_password,
})

// --------------------------------------------------------
// form action
const updateSettings = () => {
    form.patch(route('settings.update'), {
        preserveState: false,
        onSuccess: () => {
            ElNotification.success({
                message: 'Settings successfully updated',
                position: 'bottom-right',
                showClose: false,
            })
            form.reset()
        },
    })
}
</script>
