<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    /**
     * Create Menu Item
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request, Menu $menu)
    {
        $requestInput = $request->all();

        $item = new MenuItem($requestInput['item'] ?? []);
        $item->menu()->associate($menu);
        $item->saveOrFail();

        return redirect()->back();
    }

    /**
     * Show Menu Item
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @param  \App\Models\MenuItem  $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, Menu $menu, MenuItem $item)
    {
        return redirect()->route('backend.menus.items.edit', [$menu, $item]);
    }

    /**
     * Edit Menu Item
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @param  \App\Models\MenuItem  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Menu $menu, MenuItem $item)
    {
        return response()->view('backend.menus.items.edit', compact('menu', 'item'));
    }

    /**
     * Update Menu Item
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @param  \App\Models\MenuItem  $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Menu $menu, MenuItem $item)
    {
        $requestInput = $request->all();

        $item->updateOrFail($requestInput['item'] ?? []);

        return redirect()->back();
    }

    /**
     * Destroy Menu Item
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @param  \App\Models\MenuItem  $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Menu $menu, MenuItem $item)
    {
        $item->deleteOrFail();

        return redirect()->back();
    }
}
