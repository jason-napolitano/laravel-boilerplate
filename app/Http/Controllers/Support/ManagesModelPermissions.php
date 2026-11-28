<?php

namespace App\Http\Controllers\Support {

    use App\Models\User;
    use Illuminate\Database;
    use Illuminate\Support;

    trait ManagesModelPermissions
    {
        public function modelPermissionData($model): array
        {
            return [
                'permissions' => config('model-permissions.permissions'),
                'users'       => $this->withPermissionsFor($model),
                'model'       => $model
            ];
        }

        public function withPermissionsFor(Database\Eloquent\Model $model): Support\Collection
        {
            return User::query()
                ->with('modelPermissions', function ($query) use ($model) {
                    $query->where('permissionable_type', $model->getMorphClass())
                        ->where('permissionable_id', $model->getKey())
                        ->with('permission:id,name');
                })
                ->paginate(10)
                ->map(function (User $user) {
                    return [
                        'id'                  => $user['id'],
                        'name'                => $user['name'],
                        'assignedPermissions' => $user['modelPermissions']
                            ->pluck('permission.name')
                            ->filter()
                            ->values(),
                    ];
                });
        }
    }
}
