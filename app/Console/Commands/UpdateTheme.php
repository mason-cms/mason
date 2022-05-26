<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class UpdateTheme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mason:theme:update {--theme=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update theme using Composer';

    /**
     * The theme.
     *
     * @var string
     */
    protected $theme;

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
        if ($this->option('theme')) {
            $this->theme = $this->option('theme');
        } else {
            $this->theme = config('site.theme');
        }

        if (isset($this->theme) && strlen($this->theme) > 0) {
            $this->info("Updating theme: {$this->theme}");
            $this->line(shell_exec("composer update {$this->theme} --no-interaction"));
            return 0;
        } else {
            $this->error("No theme to update.");
            return 1;
        }
    }
}
