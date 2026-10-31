<?php

namespace App\Console\Commands {

    use App\Console\Commands\Support\ClearsDirectory;
    use Illuminate\Console\Attributes\Description;
    use Illuminate\Console\Attributes\Signature;
    use Illuminate\Console\Command;

    #[Signature('clear:debugbar')]
    #[Description('Clear laravel-debugbar storage files')]
    class ClearLaravelDebugbar extends Command
    {
        use ClearsDirectory;
        /**
         * Execute the console command.
         */
        public function handle(): int
        {
            if ($this->clearDirectory('debugbar')) {
                return self::SUCCESS;
            }
            return self::FAILURE;
        }
    }
}
