import type { PageProps } from '@inertiajs/core'

export interface SharedData extends PageProps {
    auth: {
        permissions: Permission[] | []
        settings: Settings
        user: User | null
    }
}

export interface DatabaseRecord {
    id: string | number
    created_at: string
    updated_at: string
    deleted_at: string
    month_updated: string
    month_created: string
    year_created: string
    year_updated: string
}

export interface Passkey extends DatabaseRecord {
    name: string
    last_used_at?: string | null
}

export interface Settings extends DatabaseRecord {
    title: string
    logo: string
    description: string
    version: string
    items_per_page: number
    enable_reset_password: boolean
    enable_registration: boolean
    enable_passkeys: boolean
    enable_2fa: boolean
}

export interface PaginateData {
    links: PaginationLink[]
    data: DatabaseRecord[]
}

export interface Media {
    id: number
    model_type: string
    model_id: number
    uuid: string
    collection_name: string
    name: string
    file_name: string
    mime_type: string | null
    disk: string
    conversions_disk: string | null
    size: number
    manipulations: Record<string, any>
    custom_properties: Record<string, any>
    generated_conversions: Record<string, boolean>
    responsive_images: Record<string, any>
    order_column: number | null
    created_at: string
    updated_at: string
    original_url?: string
    preview_url?: string
}

export interface PaginationLink {
    url: string
    label: string
    active: boolean
}

export interface Role extends DatabaseRecord {
    permissions: Permission[]
    name: string
}

export interface PaginatedRoles extends PaginateData {
    data: Role[]
}

export interface Permission extends DatabaseRecord {
    name: string
    role: Role
}

export interface PaginatedPermissions extends PaginateData {
    data: Permission[]
}

export interface User extends DatabaseRecord {
    name: string
    email: string
    roles: Role[]
    avatar?: string
    website?: string
    username: string
    is_banned: boolean
    biography?: string
    permissions: Permission[]
    email_verified_at: string | null
}

export interface PaginatedUsers extends PaginateData {
    data: User[]
}
