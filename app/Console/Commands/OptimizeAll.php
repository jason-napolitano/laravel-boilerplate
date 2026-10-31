<?php

namespace App\Console\Commands {

    use Illuminate\Console\Attributes\Description;
    use Illuminate\Console\Attributes\Signature;
    use Illuminate\Console\Command;

    #[Signature('optimize:all')]
    #[Description('Runs the maintenance optimization utility command')]
    class OptimizeAll extends Command
    {
        /**
         * Execute the console command.
         */
        public function handle(): int
        {
            // commands to run
            $commands = [
                'optimize:clear',
                'clear:debugbar',
                'clear:inertia',
                'clear:views',
            ];

            // run the commands
            foreach ($commands as $command) {
                $this->components->task($command, fn () => $this->call($command) === self::SUCCESS);
            }

            // return success
            return self::SUCCESS;
        }
    }
}
