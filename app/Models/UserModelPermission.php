<?php

namespace App\Models {

    use Illuminate\Database\Eloquent\Concerns\HasUuids;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\MorphTo;
    use Illuminate\Database\Eloquent\Model;

    class UserModelPermission extends Model
    {
        use HasUuids;

        protected $fillable = [
            'user_id',
            'permission_id',
        ];

        public function user(): BelongsTo
        {
            return $this->belongsTo(User::class);
        }

        public function permission(): BelongsTo
        {
            return $this->belongsTo(\Spatie\Permission\Models\Permission::class);
        }

        public function permissionable(): MorphTo
        {
            return $this->morphTo();
        }
    }
}
