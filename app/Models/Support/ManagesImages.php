<?php

namespace App\Models\Support {

    use Illuminate\Support;

    trait ManagesImages
    {
        public function updateImage(string $directory, string $field = 'image', string $column = 'image', ?string $filename = null): void
        {
            // delete the old image from disk storage
            $this->deleteImage($column, false);

            // request file
            $file = request()->file($field);

            // file name
            $filename ??= $this->getKey();

            // update the model
            $this->update([
                $column => "/storage/$directory/" . $filename . '.' . $file->getClientOriginalExtension()
            ]);

            // replace / upload the file into disk storage
            Support\Facades\Storage::disk('public')->putFileAs(
                $directory,
                $file,
                $filename . '.' . $file->getClientOriginalExtension()
            );
        }

        public function deleteImage(string $column = 'image', bool $updateModel = true): void
        {
            // delete the old image from disk storage
            Support\Facades\Storage::disk('public')->delete(
                str_replace('storage/', '', $this->$column)
            );

            // do we want to update the model?
            if ($updateModel) {
                $this->update([$column => null]);
            }
        }
    }
}
