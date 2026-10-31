<?php

namespace App\Models {

    use Illuminate\Database\Eloquent\Casts\Attribute;
    use Spatie\Permission\Models\Role as BaseRole;

    /**
     * @method static whereNot(string $key, string $value)
     */
    class Role extends BaseRole
    {
        use Support\FormatsDates;

        public function name(): Attribute
        {
            return Attribute::make(
                get: static fn ($value) => str($value)->title()
            );
        }
    }
}
