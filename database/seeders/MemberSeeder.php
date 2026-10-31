<?php

namespace Database\Seeders {

    use Spatie\Permission\Models\Role;
    use Illuminate\Database\Seeder;

    class MemberSeeder extends Seeder
    {
        public function run(): void
        {
            // administrator
            $member = Role::create(['name' => env('APP_DEFAULT_ROLE')]);

            $member->givePermissionTo('view_dashboard');

            $member->givePermissionTo('manage_passkeys');
            $member->givePermissionTo('delete_passkey');
            $member->givePermissionTo('create_passkey');

            $member->givePermissionTo('update_password');
            $member->givePermissionTo('update_profile');
            $member->givePermissionTo('update_image');
            $member->givePermissionTo('view_profile');
        }
    }
}
