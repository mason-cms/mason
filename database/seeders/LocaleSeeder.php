<?php

namespace Database\Seeders;

use App\Models\Locale;
use Illuminate\Database\Seeder;

class LocaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'en' => [
                'title' => "English",
                'is_default' => true,
            ],
            'fr' => [
                'title' => "Français",
                'is_default' => false,
            ],
        ];

        $res = seed($data, Locale::class, 'name');
        $out = "{$res['created']} created / {$res['updated']} updated / {$res['skipped']} skipped / {$res['errors']} errors";

        if (isset($this->command)) {
            $res['errors'] === 0
                ? $this->command->line($out)
                : $this->command->error($out);
        }
    }
}
