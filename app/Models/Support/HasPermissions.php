<?php

namespace App\Models\Support {

    use App\Models\UserModelPermission;
    use Illuminate\Database\Eloquent\Relations\MorphMany;

    trait HasPermissions
	{
        public function modelHasPermissions(): MorphMany
        {
            return $this->morphMany(UserModelPermission::class, 'permissionable');
        }
	}
}
