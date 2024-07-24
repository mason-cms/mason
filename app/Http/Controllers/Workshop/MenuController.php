<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\Locale;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MenuController extends Controller
{
    public function index(Request $request): Response
    {
        if (isset($request->location, $request->locale_id)) {
            $menu = Menu::firstOrCreate([
                'location' => $request->location,
                'locale_id' => $request->locale_id,
            ]);
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

    public function update(Request $request, Menu $menu): RedirectResponse
    {
        $requestInput = $request->all();

        if (isset($requestInput['menu']['items'])) {
            $rank = 0;

            foreach ($requestInput['menu']['items'] as $menuItemKey) {
                $item = $menu->items()->findOrFail($menuItemKey);
                $item->updateOrFail(['rank' => $rank++]);
            }
        }

        return redirect()->back();
    }
}
