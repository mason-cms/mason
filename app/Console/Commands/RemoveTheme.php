<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RemoveTheme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mason:theme:remove {--theme=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove theme using Composer';

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
            $this->info("Removing theme: {$this->theme}");

            $this->line(shell_exec("composer remove {$this->theme} --no-interaction"));

            $this->removeSymlink();

            return 0;
        } else {
            $this->error("No theme to remove.");
            return 1;
        }
    }

    protected function removeSymlink()
    {
        $link = theme_public_path('', $this->theme);

        if (is_link($link)) {
            $this->line("Removing symlink: '{$link}'");

            if (unlink($link)) {
                $this->info("Symlink removed");
            } else {
                $this->info("Symlink could not be removed");
            }
        }
    }
}
