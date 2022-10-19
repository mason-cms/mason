<?php

namespace App\Http\Controllers;

use App\Models\Locale;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    protected $site;

    public function __construct()
    {
        $this->site = site();
    }

    /**
     * Show the home page
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $localeName
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function home(Request $request, string $localeName = null)
    {
        if (isset($localeName)) {
            if (Locale::isDefault($localeName)) {
                return redirect()->route('home');
            }

            $this->site->setLocale($localeName);
        }

        $views = [
            "{$this->site->locale->system_name}/home",
            "home",
        ];

        foreach ($views as $view) {
            if (view()->exists($view)) {
                return response()->view($view, ['site' => $this->site]);
            }
        }

        if ($home = $this->site->entries()->home()->first()) {
            return response()->view($home->view(), ['site' => $this->site, 'entry' => $home]);
        }

        abort(404);
    }

    /**
     * Show a specified entry
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $params
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|void
     */
    public function entry(Request $request, ...$params)
    {
        switch (count($params)) {
            case 1:
                $entryName = $params[0];
                break;

            case 2:
                $this->site->setLocale($localeName = $params[0]);
                $entryName = $params[1];
                break;
        }

        if (isset($entryName)) {
            if ($entry = $this->site->entry($entryName)) {
                if (isset($localeName) && Locale::isDefault($localeName)) {
                    return redirect()->to($entry->url);
                }

                if ($view = $entry->view()) {
                    return response()->view($view, ['site' => $this->site, 'entry' => $entry]);
                }
            }
        }

        abort(404);
    }

    /**
     * Show a specified taxonomy
     *
     * @param Request $request
     * @param ...$params
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|void
     */
    public function taxonomy(Request $request, ...$params)
    {
        if (isset($params[0]) && Locale::exists($params[0])) {
            $this->site->setLocale($localeName = $params[0]);
            $taxonomyType = $params[1] ?? null;
            $taxonomyName = $params[2] ?? null;
            $entryType = $params[3] ?? null;
        } else {
            $taxonomyType = $params[0] ?? null;
            $taxonomyName = $params[1] ?? null;
            $entryType = $params[2] ?? null;
        }

        if (isset($taxonomyType, $taxonomyName)) {
            if ($taxonomy = $this->site->taxonomy($taxonomyName, $localeName ?? null, $taxonomyType)) {
                if (isset($localeName) && Locale::isDefault($localeName)) {
                    return redirect()->to($taxonomy->url);
                }

                $entriesQuery = $taxonomy->entries();

                if (isset($entryType)) {
                    $entriesQuery->byType($entryType);
                }

                if ($view = $taxonomy->view()) {
                    return response()->view($view, [
                        'site' => $this->site,
                        'taxonomy' => $taxonomy,
                        'entryType' => $entryType,
                        'entries' => $entriesQuery->paginate(),
                    ]);
                }
            }
        }

        abort(404);
    }
}
