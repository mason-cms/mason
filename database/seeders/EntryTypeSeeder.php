<?php

namespace Database\Seeders;

use App\Models\EntryType;
use Illuminate\Database\Seeder;

class EntryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'page' => [
                'singular_title' => "Page",
                'plural_title' => "Pages",
                'icon_class' => "fa-memo",
            ],
            'post' => [
                'singular_title' => "Post",
                'plural_title' => "Posts",
                'icon_class' => "fa-newspaper",
            ],
        ];

        $res = seed($data, EntryType::class, 'name');
        $out = "{$res['created']} created / {$res['updated']} updated / {$res['skipped']} skipped / {$res['errors']} errors";

        if (isset($this->command)) {
            $res['errors'] === 0
                ? $this->command->line($out)
                : $this->command->error($out);
        }
    }
}
