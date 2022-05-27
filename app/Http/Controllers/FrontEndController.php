<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Locale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class FrontEndController extends Controller
{
    protected function setLocale($locale = null)
    {
        $defaultLocale = Locale::default();
        $locale ??= $defaultLocale;

        if (is_string($locale)) {
            $locale = Locale::findByName($locale);
        }

        if ($locale instanceof Locale) {
            setlocale(LC_ALL, $locale->code);

            App::setLocale($locale->code);

            if ($locale !== $defaultLocale) {
                URL::defaults(['locale' => $locale->name]);
            }

            Carbon::setLocale($locale->code);

            return $locale;
        }
    }

    public function home(Request $request, $localeName = null)
    {
        $site = site();

        $locale = $this->setLocale($localeName);

        $views = [
            "{$locale->code}/home",
            "{$locale->name}/home",
            "home",
        ];

        foreach ($views as $view) {
            if (view()->exists($view)) {
                return view($view, compact('site', 'locale'));
            }
        }

        abort(404);
    }

    public function entry(Request $request, ...$params)
    {
        $site = site();

        switch (count($params)) {
            case 1:
                $locale = $this->setLocale();
                $entryName = $params[0];
                break;

            default:
                $locale = $this->setLocale($suppliedLocale = $params[0]);
                $entryName = $params[1];
                break;
        }

        $entry = $site->entry($entryName, $locale);

        if ($entry instanceof Entry) {
            if (isset($suppliedLocale) && Locale::isDefault($suppliedLocale)) {
                return redirect()->to($entry->url);
            }

            $views = [
                "{$locale->code}/{$entry->type->name}.{$entry->name}",
                "{$locale->code}/{$entry->type->name}.default",
                "{$locale->code}/{$entry->type->name}",
                "{$locale->name}/{$entry->type->name}.{$entry->name}",
                "{$locale->name}/{$entry->type->name}.default",
                "{$locale->name}/{$entry->type->name}",
                "{$entry->type->name}.{$entry->name}",
                "{$entry->type->name}.default",
                "{$entry->type->name}",
            ];

            foreach ($views as $view) {
                if (view()->exists($view)) {
                    return view($view, compact('site', 'entry', 'locale'));
                }
            }
        }

        abort(404);
    }
}
