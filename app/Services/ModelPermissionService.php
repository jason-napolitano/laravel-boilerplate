<?php

namespace App\Services {

    use App\Models\User;
    use Illuminate\Database\Eloquent\Model;
    use Spatie\Permission\Models\Permission;

    class ModelPermissionService
    {
        public function grant(User $user, Model $model, $permission): void
        {
            $permission = Permission::findByName($permission, 'web');

            $model->modelHasPermissions()->firstOrCreate([
                'user_id'       => $user->id,
                'permission_id' => $permission->id,
            ]);
        }

        public function revoke(User $user, Model $model, string $permission): void
        {
            $permission = Permission::findByName($permission, 'web');

            $model->modelHasPermissions()
                ->where('user_id', $user->id)
                ->where('permission_id', $permission->id)
                ->delete();
        }
    }
}
