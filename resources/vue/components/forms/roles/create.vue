<template>
    <el-button @click="toggleDialog" :icon="Users">Create Role</el-button>

    <el-dialog v-model="dialogOpen" width="350" title="Create Role">
        <el-form @submit.prevent="submitForm">
            <el-form-item :error="form.errors.name" label="Name">
                <el-input v-model="form.name" />
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
import { Users } from 'lucide-vue-next'

// --------------------------------------------------------
// form data
const form = useForm({
    name: '',
})

// --------------------------------------------------------
// form actions
const submitForm = () =>
    form.post(route('roles.store'), {
        onSuccess: () => {
            form.reset()
            toggleDialog()
        },
    })

// --------------------------------------------------------
// dialog
const { toggleDialog, dialogOpen } = useDialog()
</script>
