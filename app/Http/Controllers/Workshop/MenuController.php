<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\Locale;
use App\Models\Menu;
use App\Models\MenuItem;
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

        return response()->view('workshop.menus.index', [
            'request' => $request,
            'site' => $site = site(false),
            'menuLocations' => $site->theme()->menuLocations(),
            'location' => $location ?? null,
            'locales' => Locale::all(),
            'menu' => $menu ?? null,
        ]);
    }

    /**
     * Update Menu
     *
     * @param Request $request
     * @param Menu $menu
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Menu $menu)
    {
        $requestInput = $request->all();

        if (isset($requestInput['menu']['items'])) {
            $rank = 0;

            foreach ($requestInput['menu']['items'] as $menuItemKey) {
                if ($menuItem = MenuItem::find($menuItemKey)) {
                    $menuItem->update(['rank' => $rank++]);
                }
            }
        }

        return redirect()->back();
    }
}