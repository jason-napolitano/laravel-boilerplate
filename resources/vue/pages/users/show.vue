<template>
    <dashboard-layout :title="`${pluralPossessive(props.user['name'])} Profile`">
        <template #headingRight>
            <el-button v-if="isCurrentUser(props.user)" :icon="Lock" @click="logout">Terminate Session</el-button>
        </template>
        <div class="flex gap-4">
            <aside class="w-1/4 md:w-1/5">
                <user-image
                    :can-update="currentUserCan(props.user, 'update_image')"
                    image-class="h-full w-full object-cover"
                    :can-delete="isCurrentUser(props.user)"
                    delete-route="users.image.destroy"
                    upload-route="users.image"
                    :model="props.user"
                    column="avatar"
                />
            </aside>

            <div class="flex w-3/4 flex-col space-y-4 md:w-4/5">
                <el-tabs tab-position="top" type="border-card" v-model="byQueryParam">
                    <el-tab-pane label="Profile Details" name="details">
                        <div class="flex flex-col space-y-2">
                            <el-divider content-position="left">Details</el-divider>
                            <div>
                                <div class="font-bold">Full Name</div>
                                <div class="text-sm">{{ props.user['name'] }}</div>
                            </div>
                            <div>
                                <div class="font-bold">Username</div>
                                <div class="text-sm">{{ props.user['username'] }}</div>
                            </div>
                            <div>
                                <div class="font-bold">Email Address</div>
                                <email-link :email="props.user['email']" :text="props.user['email']" :show-icon="false" />
                            </div>
                            <div>
                                <div class="font-bold">Member Since</div>
                                <div class="text-sm">{{ props.user['created_at'] }}</div>
                            </div>

                            <el-divider content-position="left">Biography</el-divider>
                            <div v-text="props.user['biography']" class="text-justify text-stone-400" />
                        </div>
                    </el-tab-pane>
                    <el-tab-pane label="Update Profile" v-if="currentUserCan(props.user, 'update_profile')" name="update">
                        <edit-form :user="props.user" />
                    </el-tab-pane>
                    <el-tab-pane label="Update Security" v-if="currentUserCan(props.user, 'update_security')" name="security">
                        <el-tabs tab-position="left">
                            <el-tab-pane label="Password" v-if="currentUserCan(props.user, 'update_password')">
                                <div class="flex justify-end">
                                    <el-button @click="forgotPassword(props.user['email'])">Send Reset Password Email</el-button>
                                </div>
                                <password-form :user="props.user" />
                            </el-tab-pane>
                            <el-tab-pane
                                v-if="currentUserCan(props.user, 'manage_passkeys') && $page.props.settings['enable_passkeys']"
                                label="Passkeys"
                            >
                                <div class="flex flex-col gap-2">
                                    <el-alert> Use the form below to manage your passkey details. </el-alert>
                                    <div class="flex justify-end">
                                        <register-passkey :user="props.user" />
                                    </div>
                                    <pass-keys-table :passkeys="props.passkeys" />
                                </div>
                            </el-tab-pane>
                        </el-tabs>
                    </el-tab-pane>
                </el-tabs>
            </div>
        </div>
    </dashboard-layout>
</template>

<script setup lang="ts">
// --------------------------------------------------------
// imports
import PasswordForm from '@/components/forms/users/password.vue'
import RegisterPasskey from '@/components/passkeys/register.vue'
import PassKeysTable from '@/components/passkeys/table.vue'
import EmailLink from '@/components/links/email-link.vue'
import EditForm from '@/components/forms/users/edit.vue'
import UserImage from '@/components/media/image.vue'
import type { User, Passkey } from '@/types'
import { Lock } from 'lucide-vue-next'

// --------------------------------------------------------
// component props
const props = defineProps<{
    passkeys: Passkey[]
    user: User
}>()

// --------------------------------------------------------
// auth checks
const { logout, currentUserCan, isCurrentUser, forgotPassword } = useAuth()

// --------------------------------------------------------
// string manipulation
const { pluralPossessive } = useString()

// --------------------------------------------------------
// tab based routing
const { byQueryParam } = useTabs('details')
</script>
