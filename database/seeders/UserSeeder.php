<?php

namespace Database\Seeders {

    use Illuminate\Database\Seeder;
    use App\Models\User;

    class UserSeeder extends Seeder
    {
        public function run(): void
        {
            for ($i = 0; $i < 250; $i++) {
                $user = User::factory()->create();
                $user->assignRole(env('APP_DEFAULT_ROLE'));
            }
        }
    }
}
