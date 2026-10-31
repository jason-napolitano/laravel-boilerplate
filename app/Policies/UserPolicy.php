<?php

namespace App\Policies {

    use App\Models\User;

    class UserPolicy
    {
        public function viewAny(User $user): bool
        {
            return $user->can('manage_users');
        }

        public function view(User $user, User $model): bool
        {
            // return $user->is($model) && $user->can('view_profile');
            return $user->can('view_profile');
        }

        public function create(User $user): bool
        {
            return $user->can('create_user');
        }

        public function update(User $user, User $model): bool
        {
            return $user->is($model) && $user->can('update_profile');
        }

        public function updateImage(User $user, User $model): bool
        {
            return $user->is($model) && $user->can('update_image');
        }

        public function updateRole(User $user, User $model): bool
        {
            return $user->is($model) && $user->can('update_role');
        }

        public function delete(User $user, User $model): bool
        {
            return $user->is($model) && $user->can('delete_user');
        }

        public function banUser(User $user, User $model): bool
        {
            return $user->can('ban_user');
        }
    }
}
