<?php

namespace App\Console\Commands;

use App\Models\Theme;
use Illuminate\Console\Command;

class InstallTheme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mason:theme:install {--theme=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install theme using Composer';

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
        $this->theme = theme($this->option('theme') ? $this->option('theme') : null);

        if (isset($this->theme) && $this->theme instanceof Theme && isset($this->theme->name)) {
            $this->info("Installing theme: {$this->theme->name}");

            if ($this->theme->install()) {
                $this->info("Theme installed");
                return 0;
            } else {
                $this->error("Theme could not be installed");
                return 1;
            }
        } else {
            $this->error("No theme to install.");
            return 1;
        }
    }
}
