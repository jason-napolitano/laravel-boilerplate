<?php

namespace App\Console\Commands\Support {

    use Illuminate\Support\Facades\File;

    trait ClearsDirectory
    {
        /**
         * Clears the files and subdirectories of a directory that
         * lives within `/storage`
         *
         * @param string $directory
         * @param bool $deleteSubDirectories
         *
         * @return bool
         */
        public function clearDirectory(string $directory, bool $deleteSubDirectories = false): bool
        {
            // path location
            $path = storage_path($directory);

            // check if $path is a directory
            if (!File::isDirectory($path)) {
                $this->warn("$directory does not exist.");
                return false;
            }

            // files within $path
            $files = File::allFiles($path);

            // for through each $file
            foreach ($files as $file) {
                // ignore .gitignore files
                if ($file->getFilename() === '.gitignore') {
                    continue;
                }

                // delete the $file
                File::delete($file->getPathname());
            }

            // delete subdirectories
            if ($deleteSubDirectories) {
                $directories = File::directories($path);

                foreach ($directories as $d) {
                    File::deleteDirectory($d);
                }
            }

            return true;
        }
    }
}
