<?php

namespace App\Models {

    use App\Models\Support\HasPermissions;

    class Category extends BaseModel
    {
        use HasPermissions;

        /** @inheritDoc **/
        protected $fillable = [
            'name'
        ];
    }
}
