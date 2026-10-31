<template>
    <el-button :icon="SquarePen" @click="toggleDialog"> Create User </el-button>

    <el-dialog v-model="dialogOpen" width="450">
        <el-form @submit.prevent="submit">
            <el-row>
                <el-col :span="12">
                    <el-form-item label="Name" :error="form.errors.name">
                        <el-input v-model="form.name" />
                    </el-form-item>
                </el-col>

                <el-col :span="12">
                    <el-form-item label="Username" :error="form.errors.username">
                        <el-input v-model="form.username" />
                    </el-form-item>
                </el-col>
            </el-row>

            <el-form-item label="Email Address" :error="form.errors.email">
                <el-input v-model="form.email" />
            </el-form-item>

            <el-row>
                <el-col :span="12">
                    <el-form-item label="Password" :error="form.errors.password">
                        <el-input v-model="form.password" type="password" />
                    </el-form-item>
                </el-col>
                <el-col :span="12">
                    <el-form-item label="Confirm Password" :error="form.errors.password_confirmation">
                        <el-input v-model="form.password_confirmation" type="password" />
                    </el-form-item>
                </el-col>
            </el-row>

            <el-form-item label="Role">
                <el-select v-model="form.role_id">
                    <el-option v-for="role in props.roles" :key="role['id']" :value="role['id']" :label="roleName(role)" />
                </el-select>
            </el-form-item>

            <el-form-item>
                <el-button size="default" native-type="submit" class="w-full" :loading="form.processing"> Submit </el-button>
            </el-form-item>
        </el-form>
    </el-dialog>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { useDialog } from '@/composables/useDialog'
import { SquarePen } from 'lucide-vue-next'
import { Role } from '@/types'

// --------------------------------------------------------
// props
const props = defineProps<{
    roles: Role[]
}>()

// --------------------------------------------------------
// role name
const { ucFirst } = useString()

const roleName = (role: Role) => computed(() => ucFirst(role['name']))

// --------------------------------------------------------
// dialog window
const { toggleDialog, dialogOpen } = useDialog()

// --------------------------------------------------------
// form data
const form = useForm({
    name: '',
    email: '',
    username: '',
    password: '',
    role_id: null,
    password_confirmation: '',
})

const submit = () => {
    form.post(route('users.store'), {
        onSuccess: () => {
            form.reset()
            toggleDialog()
        },
    })
}
</script>
