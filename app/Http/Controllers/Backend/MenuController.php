<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Locale;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display menu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (isset($request->location, $request->locale_id)) {
            $menu = Menu::where([
                'location' => $request->location,
                'locale_id' => $request->locale_id,
            ])->first();
        }

        return response()->view('backend.menus.index', [
            'request' => $request,
            'site' => $site = site(),
            'menuLocations' => $site->theme()->menuLocations(),
            'location' => $location ?? null,
            'locales' => Locale::all(),
            'menu' => $menu ?? null,
        ]);
    }
}
