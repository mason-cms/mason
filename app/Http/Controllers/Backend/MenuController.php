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
        $site = site();
        $menuLocations = $site->theme()->menuLocations();

        $query = Menu::query();

        if (isset($request->location)) {
            $query->byLocation($location = $request->location);
        }

        $total = $query->count();

        $menus = $query->paginate($perPage = $request->input('per_page') ?? 25);

        return response()->view('backend.menus.index', [
            'site' => $site,
            'menuLocations' => $menuLocations,
            'location' => $location ?? null,
            'menus' => $menus,
            'total' => $total,
            'perPage' => $perPage,
        ]);
    }

    /**
     * Show the form for creating a new menu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        $menu = new Menu;
        $menu->locale()->associate(Locale::default());
        $menu->save();

        return redirect()->route('backend.menus.edit', [$menu]);
    }

    /**
     * Display the specified menu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, Menu $menu)
    {
        return redirect()->route('backend.menus.edit', [$menu]);
    }

    /**
     * Show the form for editing the specified menu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Menu $menu)
    {
        $site = site();
        $menuLocations = $site->theme()->menuLocations();

        return response()->view('backend.menus.edit', compact('site', 'menuLocations', 'menu'));
    }

    /**
     * Update the specified menu in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Menu $menu)
    {
        $requestInput = $request->all();

        $menu->update($requestInput['menu'] ?? []);

        return redirect()->back();
    }

    /**
     * Remove the specified menu from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Menu $menu)
    {
        $menu->delete();

        return redirect()->route('backend.menus.index');
    }
}
