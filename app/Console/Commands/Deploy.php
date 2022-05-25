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
    protected $signature = 'mason:deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize Mason CMS app.';

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
        $dotEnv = base_path('.env');
        $dotEnvExample = base_path('.env.example');

        if (! file_exists($dotEnv)) {
            if (file_exists($dotEnvExample)) {
                $this->info("Creating .env file from .env.example");

                if (! copy($dotEnvExample, $dotEnv)) {
                    $this->error("Could not copy .env file");
                    return 1;
                }
            } else {
                $this->error("File .env.example does not exist");
                return 1;
            }
        }

        $this->info("Installing composer dependencies...");
        shell_exec("composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev");

        $this->info("Installing npm dependencies...");
        shell_exec("npm install");
        shell_exec("npm run production");

        if (! env('APP_KEY')) {
            $this->info("Generating new app key...");
            Artisan::call('key:generate');
        }

        $this->info("Running database migrations...");
        Artisan::call('migrate --force');

        $this->info("Clearing cache...");
        Artisan::call('clear-compiled');

        $this->info("Optimizing...");
        Artisan::call('optimize');

        $this->info("Seeding database...");
        Artisan::call('db:seed --force');

        $this->info("Restarting queues...");
        Artisan::call('queue:restart');

        $this->info("Deployment completed.");

        return 0;
    }
}
