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

            try {
                $this->line(run("composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev"));
                $this->line(run("npm install"));
                $this->line(run("npm run production"));
            } catch (\Exception $e) {
                $this->error($e);
                return Command::FAILURE;
            }
        }

        $this->info("Running database migrations...");
        Artisan::call('migrate --force', [], $this->getOutput());

        $this->info("Clearing compiled...");
        Artisan::call('clear-compiled', [], $this->getOutput());

        $this->info("Clearing route cache...");
        Artisan::call('route:clear', [], $this->getOutput());
        Artisan::call('route:cache', [], $this->getOutput());

        $this->info("Restarting queues...");
        Artisan::call('queue:restart', [], $this->getOutput());

        $this->info("Mason deployment completed.");

        return Command::SUCCESS;
    }
}
