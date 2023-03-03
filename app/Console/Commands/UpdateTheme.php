<?php

namespace App\Console\Commands;

use App\Models\Theme;
use Illuminate\Console\Command;

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
        $this->theme = theme($this->option('theme') ? $this->option('theme') : null);

        if (isset($this->theme) && $this->theme instanceof Theme && isset($this->theme->name)) {
            $this->info("Updating theme: {$this->theme->name}");

            try {
                $this->theme->update();
                $this->info("Theme updated");
                return Command::SUCCESS;
            } catch (\Exception $e) {
                \Sentry\captureException($e);
                $this->error($e);
                return Command::FAILURE;
            }
        } else {
            $this->error("No theme to update.");
            return Command::FAILURE;
        }
    }
}
