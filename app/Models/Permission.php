<?php

namespace App\Models {

    use Spatie\Permission\Models\Permission as BasePermission;
    use Illuminate\Database\Eloquent\Casts\Attribute;

    /**
     * @method static whereNot(string $key, string $value)
     */
    class Permission extends BasePermission
    {
        use Support\FormatsDates;

        protected function name(): Attribute
        {
            return Attribute::make(
                get: static fn ($value) => str($value)->title()->replace('_', ' ')
            );
        }
    }
}
