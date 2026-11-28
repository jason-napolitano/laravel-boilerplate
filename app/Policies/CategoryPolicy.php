<?php

namespace App\Policies {

    use App\Models;

    class CategoryPolicy
    {
        public function update(Models\User $user, Models\Category $category): bool
        {
            return $user->hasModelPermission('update', $category);
        }

        public function read(Models\User $user, Models\Category $category): bool
        {
            return $user->hasModelPermission('read', $category);
        }

        public function delete(Models\User $user, Models\Category $category): bool
        {
            return $user->hasModelPermission('delete', $category);
        }
    }
}
