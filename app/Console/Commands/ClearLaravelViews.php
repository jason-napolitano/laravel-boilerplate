<?php

namespace App\Console\Commands {

    use App\Console\Commands\Support\ClearsDirectory;
    use Illuminate\Console\Attributes\Description;
    use Illuminate\Console\Attributes\Signature;
    use Illuminate\Console\Command;

    #[Signature('clear:views')]
    #[Description('Clear laravel views storage files')]
    class ClearLaravelViews extends Command
    {
        use ClearsDirectory;
        /**
         * Execute the console command.
         */
        public function handle(): int
        {
            if ($this->clearDirectory('framework/views')) {
                return self::SUCCESS;
            }
            return self::FAILURE;
        }
    }
}
