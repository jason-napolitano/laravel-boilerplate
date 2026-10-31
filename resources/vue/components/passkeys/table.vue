<template>
    <el-table :data="props.passkeys" border>
        <el-table-column label="Passkey" prop="name" />
        <el-table-column label="Registered">
            <template #default="scope: TableRow">
                {{ fromLaravelDate(scope.row['created_at'], 'MMMM DD, YYYY') }}
            </template>
        </el-table-column>
        <el-table-column label="Last Used">
            <template #default="scope">
                {{ lastUsedAt(scope.row) }}
            </template>
        </el-table-column>

        <el-table-column width="65">
            <template #default="scope">
                <el-button type="danger" :icon="Trash2" @click="deletePasskey(scope.row['id'])" />
            </template>
        </el-table-column>
    </el-table>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import { Trash2 } from 'lucide-vue-next'
import { Passkey } from '@/types'

interface TableRow {
    row: Passkey
}

// --------------------------------------------------------
// props
const props = defineProps<{
    passkeys: Passkey[]
}>()

// --------------------------------------------------------
// passkey actions
const { deletePasskey, lastUsedAt } = usePasskey()

// --------------------------------------------------------
// date formatting
const { fromLaravelDate } = useDate()
</script>
