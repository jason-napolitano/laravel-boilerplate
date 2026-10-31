<?php

namespace App\Console\Commands {

    use App\Console\Commands\Support\ClearsDirectory;
    use Illuminate\Console\Attributes\Description;
    use Illuminate\Console\Attributes\Signature;
    use Illuminate\Console\Command;

    #[Signature('clear:inertia')]
    #[Description('Clear inertia devtools storage files')]
    class ClearInertiaDevtools extends Command
    {
        use ClearsDirectory;

        /**
         * Execute the console command.
         */
        public function handle(): int
        {
            if ($this->clearDirectory('inertia-devtools')) {
                return self::SUCCESS;
            }
            return self::FAILURE;
        }
    }
}
