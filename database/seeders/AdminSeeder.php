<?php

namespace Database\Seeders {

    use Spatie\Permission\Models\Role;
    use Illuminate\Database\Seeder;
    use App\Models\User;

    class AdminSeeder extends Seeder
    {
        public function run(): void
        {
            // administrator
            $admin = Role::create(['name' => 'admin']);
            $admin->givePermissionTo('*');

            $user = User::create([
                'password'      => bcrypt('password'),
                'email'         => 'admin@example.com',
                'username'      => fake()->unique()->username(),
                'name'          => fake()->name(),
                'biography'     => fake()->paragraph(15),
            ]);
            $user->assignRole($admin);
        }
    }
}
