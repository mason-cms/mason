<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

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
        if ($this->option('theme')) {
            $this->theme = $this->option('theme');
        } else {
            $this->theme = config('site.theme');
        }

        if (isset($this->theme) && strlen($this->theme) > 0) {
            $this->info("Installing theme: {$this->theme}");

            $this->line(shell_exec("composer require {$this->theme} --no-interaction"));

            $this->createSymlink();

            return 0;
        } else {
            $this->error("No theme to install.");
            return 1;
        }
    }

    protected function createSymlink()
    {
        $target = theme_path('public', $this->theme);
        $link = theme_public_path('', $this->theme);

        if (is_link($link)) unlink($link);

        $this->line("Creating symlink between '{$target}' and '{$link}'");

        if (symlink($target, $link)) {
            $this->info("Symlink created");
        } else {
            $this->info("Symlink could not be created");
        }
    }
}
