<?php

namespace App\Models {

    use Illuminate\Database\Eloquent\Relations\MorphMany;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Database\Eloquent\Attributes\UsePolicy;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Attributes\Hidden;
    use Illuminate\Database\Eloquent\Concerns\HasUuids;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Laravel\Fortify\PasskeyAuthenticatable;
    use Laravel\Fortify\Contracts\PasskeyUser;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Database\Eloquent\Model;
    use Spatie\Permission\Traits\HasRoles;
    use App\Models\Support\ManagesImages;
    use App\Models\Support\FormatsDates;
    use App\Policies\UserPolicy;

    /**
     * @method static create(array $data)
     */
    #[Hidden(['password', 'remember_token'])]
    #[UsePolicy(UserPolicy::class)]
    class User extends Authenticatable implements PasskeyUser
    {
        use PasskeyAuthenticatable;
        use ManagesImages;
        use FormatsDates;
        use Notifiable;
        use HasFactory;
        use HasRoles;
        use HasUuids;

        protected $fillable = [
            'last_login_at',
            'last_login_ip',
            'is_banned',
            'biography',
            'password',
            'username',
            'avatar',
            'email',
            'name',
        ];

        protected $appends = [
            'month_created',
            'year_created',
        ];

        protected function casts(): array
        {
            return [
                'email_verified_at' => 'datetime',
                'updated_at'        => 'datetime',
                'created_at'        => 'datetime',
                'password'          => 'hashed',
                'is_banned'         => 'boolean',
            ];
        }

        public function toggleBan(bool $save = true): void
        {
            $this->is_banned = !$this->is_banned;

            // do we save the model?
            if ($save) {
                $this->save();
            }
        }

        public function scopeIsBanned(Builder $query): void
        {
            $query->where('is_banned', true);
        }

        public function scopeIsNotBanned(Builder $query): void
        {
            $query->where('is_banned', false);
        }

        // permissionable helpers
        public function modelPermissions(): HasMany
        {
            return $this->hasMany(UserModelPermission::class);
        }

        public function hasModelPermission(string $permission, BaseModel $model): bool
        {
            return $this->modelPermissions()->whereHas('permission', fn($query) => $query->where('name', $permission))
                ->where('permissionable_type', $model->getMorphClass())
                ->where('permissionable_id', $model->getKey())
                ->exists();
        }

        public function getModelPermissions(Model $model): array
        {
            return $this->modelPermissions()
                ->where('permissionable_type', $model->getMorphClass())
                ->where('permissionable_id', $model->getKey())
                ->with('permission:id,name')
                ->get()
                ->pluck('permission.name')
                ->filter()
                ->values()
                ->all();
        }
    }
}
