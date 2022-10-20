<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Deploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mason:deploy {--quick}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy Mason CMS app.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (! $this->option('quick')) {
            $this->info("Installing composer dependencies...");
            $this->line(shell_exec("composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev"));

            $this->info("Installing npm dependencies...");
            $this->line(shell_exec("npm install"));
            $this->line(shell_exec("npm run production"));
        }

        $this->info("Running database migrations...");
        Artisan::call('migrate --force', [], $this->getOutput());

        $this->info("Clearing cache...");
        Artisan::call('clear-compiled', [], $this->getOutput());

        $this->info("Optimizing...");
        Artisan::call('optimize', [], $this->getOutput());

        $this->info("Restarting queues...");
        Artisan::call('queue:restart', [], $this->getOutput());

        $this->info("Mason deployment completed.");

        return Command::SUCCESS;
    }
}
