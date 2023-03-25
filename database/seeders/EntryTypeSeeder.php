<?php

namespace Database\Seeders;

use App\Enums\EditorMode;
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
                'icon_class' => "fa-file-lines",
                'default_editor_mode' => EditorMode::CODE,
                'default_order_column' => 'title',
                'default_order_direction' => 'asc',
            ],

            'post' => [
                'singular_title' => "Post",
                'plural_title' => "Posts",
                'icon_class' => "fa-newspaper",
                'default_editor_mode' => EditorMode::WYSIWYG,
                'default_order_column' => 'created_at',
                'default_order_direction' => 'desc',
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
