<?php

namespace Database\Seeders;

use App\Models\TaxonomyType;
use Illuminate\Database\Seeder;

class TaxonomyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'category' => [
                'singular_title' => "Category",
                'plural_title' => "Categories",
                'icon_class' => "fa-folder-open",
            ],

            'tag' => [
                'singular_title' => "Tag",
                'plural_title' => "Tags",
                'icon_class' => "fa-tag",
            ],
        ];

        $res = seed($data, TaxonomyType::class, 'name');
        $out = "{$res['created']} created / {$res['updated']} updated / {$res['skipped']} skipped / {$res['errors']} errors";

        if (isset($this->command)) {
            $res['errors'] === 0
                ? $this->command->line($out)
                : $this->command->error($out);
        }
    }
}
