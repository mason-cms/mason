<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mason:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Mason CMS app.';

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
        if (! file_exists($dotEnv = base_path('.env'))) {
            if (file_exists($dotEnvExample = base_path('.env.example'))) {
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

        $this->info("Generating new app key...");
        Artisan::call('key:generate');

        switch (env('FILESYSTEM_DRIVER')) {
            case 'local':
                $this->info("Creating storage symlink...");
                Artisan::call('storage:link');
                break;
        }

        $this->info("Mason installation completed.");

        return 0;
    }
}
