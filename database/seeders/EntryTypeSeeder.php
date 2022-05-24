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
        $entryTypeData = [
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

        foreach ($entryTypeData as $name => $attributes) {
            if ($entryType = EntryType::where('name', $name)->first()) {
                $entryType->update($attributes);
            } else {
                $entryType = new EntryType;
                $entryType->name = $name;
                $entryType->fill($attributes);
                $entryType->save();
            }
        }
    }
}
