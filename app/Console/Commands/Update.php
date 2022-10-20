<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mason:update {--branch=master} {--deploy}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Mason CMS app.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Updating Mason CMS...");

        $basePath = base_path();
        $branch = $this->option('branch');

        $cmdOutput = shell_exec("cd {$basePath}; git checkout {$branch}; git pull origin {$branch};");

        $this->line("{$cmdOutput}");

        if ($this->option('deploy')) {
            Artisan::call('mason:deploy');
        }

        $this->info("Mason update completed.");

        return Command::SUCCESS;
    }
}
