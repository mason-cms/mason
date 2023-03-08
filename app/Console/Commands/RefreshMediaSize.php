<?php

namespace App\Console\Commands;

use App\Models\Medium;
use Illuminate\Console\Command;

class RefreshMediaSize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mason:media:size:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $images = Medium::images();
        $count = $images->count();

        if ($count > 0) {
            if ($this->confirm("Refresh size for {$count} images?")) {
                foreach ($images->cursor() as $image) {
                    if ($image->calcImageSize()) {
                        $this->info("'{$image->title}': {$image->image_width}x{$image->image_height}");
                        $image->save();
                    } else {
                        $this->error("'{$image->title}': could not calculate image size");
                    }
                }
            }
        } else {
            $this->info("No images.");
        }

        return Command::SUCCESS;
    }
}
