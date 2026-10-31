<?php

namespace App\Models\Support {

    use Illuminate\Database;
    use Carbon\Carbon;

    trait FormatsDates
    {
        private static string $format = 'M j, Y';

        protected function createdAt(): Database\Eloquent\Casts\Attribute
        {
            return Database\Eloquent\Casts\Attribute::make(
                get: static fn ($value) => Carbon::parse($value)->format(self::$format),
            );
        }

        protected function updatedAt(): Database\Eloquent\Casts\Attribute
        {
            return Database\Eloquent\Casts\Attribute::make(
                get: static fn ($value) => Carbon::parse($value)->format(self::$format),
            );
        }

        protected function monthCreated(): Database\Eloquent\Casts\Attribute
        {
            return Database\Eloquent\Casts\Attribute::make(
                get: fn () => Carbon::create($this->created_at)->format('F'),
            );
        }

        protected function yearCreated(): Database\Eloquent\Casts\Attribute
        {
            return Database\Eloquent\Casts\Attribute::make(
                get: fn () => Carbon::create($this->created_at)->format('Y'),
            );
        }

        protected function monthUpdated(): Database\Eloquent\Casts\Attribute
        {
            return Database\Eloquent\Casts\Attribute::make(
                get: fn () => Carbon::create($this->updated_at)->format('F'),
            );
        }

        protected function yearUpdated(): Database\Eloquent\Casts\Attribute
        {
            return Database\Eloquent\Casts\Attribute::make(
                get: fn () => Carbon::create($this->updated_at)->format('Y'),
            );
        }
    }
}
