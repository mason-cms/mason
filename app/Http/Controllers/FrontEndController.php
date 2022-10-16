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
    public function home(Request $request, $localeName = null)
    {
        if (isset($localeName) && Locale::isDefault($localeName)) {
            return redirect()->route('home');
        }

        $this->site->setLocale($localeName);

        $views = [
            "{$this->site->locale->name}/home",
            "home",
        ];

        foreach ($views as $view) {
            if (view()->exists($view)) {
                return response()->view($view, ['site' => $this->site]);
            }
        }

        abort(404);
    }

    /**
     * Show a specified entry
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $params
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function entry(Request $request, ...$params)
    {
        switch (count($params)) {
            case 1:
                $entryName = $params[0];
                break;

            default:
                $this->site->setLocale($localeName = $params[0]);
                $entryName = $params[1];
                break;
        }

        if ($entry = $this->site->entry($entryName)) {
            if (isset($localeName) && Locale::isDefault($localeName)) {
                return redirect()->to($entry->url);
            }

            return response()->view($entry->view(), ['site' => $this->site, 'entry' => $entry]);
        }

        abort(404);
    }
}
