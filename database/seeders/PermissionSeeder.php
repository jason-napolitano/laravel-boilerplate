<?php

namespace Database\Seeders {

    use Spatie\Permission\Models\Permission;
    use Illuminate\Database\Seeder;

    class PermissionSeeder extends Seeder
    {
        public function run(): void
        {
            // --------------------------------------------
            // settings
            Permission::create(['name' => 'manage_settings']);
            Permission::create(['name' => 'update_settings']);
            Permission::create(['name' => 'update_app_title']);
            Permission::create(['name' => 'update_app_logo']);
            Permission::create(['name' => 'update_app_version']);
            Permission::create(['name' => 'update_items_per_page']);
            Permission::create(['name' => 'update_app_description']);
            Permission::create(['name' => 'enable_password_reset_settings']);
            Permission::create(['name' => 'enable_registration_settings']);
            Permission::create(['name' => 'enable_passkeys_settings']);

            // --------------------------------------------
            // dashboard
            Permission::create(['name' => 'view_dashboard']);

            // --------------------------------------------
            // users
            Permission::create(['name' => 'manage_banned_users']);
            Permission::create(['name' => 'manage_users']);
            Permission::create(['name' => 'manage_user']);
            Permission::create(['name' => 'create_user']);
            Permission::create(['name' => 'update_user']);
            Permission::create(['name' => 'delete_user']);
            Permission::create(['name' => 'unban_user']);
            Permission::create(['name' => 'view_user']);
            Permission::create(['name' => 'ban_user']);

            // --------------------------------------------
            // roles
            Permission::create(['name' => 'manage_roles']);
            Permission::create(['name' => 'manage_role']);
            Permission::create(['name' => 'create_role']);
            Permission::create(['name' => 'update_role']);
            Permission::create(['name' => 'delete_role']);

            // --------------------------------------------
            // permissions
            Permission::create(['name' => 'add_permission_to_role']);
            Permission::create(['name' => 'manage_permissions']);
            Permission::create(['name' => 'manage_permission']);
            Permission::create(['name' => 'create_permission']);
            Permission::create(['name' => 'update_permission']);
            Permission::create(['name' => 'delete_permission']);

            // --------------------------------------------
            // passkeys
            Permission::create(['name' => 'manage_passkeys']);
            Permission::create(['name' => 'delete_passkey']);
            Permission::create(['name' => 'create_passkey']);

            // --------------------------------------------
            // profile
            Permission::create(['name' => 'delete_profile_image']);
            Permission::create(['name' => 'update_profile_image']);
            Permission::create(['name' => 'update_password']);
            Permission::create(['name' => 'update_profile']);
            Permission::create(['name' => 'view_profile']);

            // admin wildcard
            Permission::create(['name' => '*']);
        }
    }
}
