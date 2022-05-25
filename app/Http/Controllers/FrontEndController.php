<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Locale;
use App\Models\Post;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class FrontEndController extends Controller
{
    protected function setLocale(&$locale = null)
    {
        $defaultLocale = Locale::default();
        $locale ??= $defaultLocale;

        if (is_string($locale)) {
            $locale = Locale::byName($locale)->first();
        }

        setlocale(LC_ALL, $locale);

        App::setLocale($locale);

        if ($locale !== $defaultLocale) {
            URL::defaults(['locale' => $locale]);
        }

        Carbon::setLocale($locale);

        return $locale;
    }

    public function entry(Request $request, string $locale = null, Entry $entry = null)
    {
        $this->setLocale($locale);

        if (isset($entry)) {
            $views = [
                "{$locale}/{$entry->type->name}.{$entry->name}",
                "{$locale}/{$entry->type->name}.default",
                "{$locale}/{$entry->type->name}",
                "{$entry->type->name}.{$entry->name}",
                "{$entry->type->name}.default",
                "{$entry->type->name}",
            ];
        } else {
            $views = [
                "{$locale}/home",
                "home",
            ];
        }

        foreach ($views as $view) {
            if (view()->exists($view)) {
                return view($view, compact('locale', 'entry'));
            }
        }

        abort(404);
    }
}
