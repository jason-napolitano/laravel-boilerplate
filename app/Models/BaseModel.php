<?php

namespace App\Models {

    use Illuminate\Database\Eloquent;

    /**
     * @method static create($data)
     * @method static first()
     */
    class BaseModel extends Eloquent\Model
    {
        use Eloquent\Factories\HasFactory;
        use Eloquent\Concerns\HasUuids;
        use Support\ManagesImages;
        use Eloquent\SoftDeletes;
        use Support\FormatsDates;
    }
}
