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
        $localeData = [
            'en' => [
                'title' => "English",
            ],
            'fr' => [
                'title' => "Français",
            ],
        ];

        foreach ($localeData as $name => $attributes) {
            if ($locale = Locale::where('name', $name)->first()) {
                $locale->update($attributes);
            } else {
                $locale = new Locale;
                $locale->name = $name;
                $locale->fill($attributes);
                $locale->save();
            }
        }
    }
}
