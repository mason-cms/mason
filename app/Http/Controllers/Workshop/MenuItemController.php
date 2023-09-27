<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MenuItemController extends Controller
{
    public function create(Request $request, Menu $menu): RedirectResponse
    {
        $item = $menu->items()->make($request->all()['item'] ?? []);

        $item->saveOrFail();

        return redirect()->back();
    }

    public function show(Request $request, Menu $menu, MenuItem $item): RedirectResponse
    {
        return redirect()->route('workshop.menus.items.edit', [$menu, $item]);
    }

    public function edit(Request $request, Menu $menu, MenuItem $item): Response
    {
        return response()->view('workshop.menus.items.edit', [
            'request' => $request,
            'menu' => $menu,
            'item' => $item,
        ]);
    }

    public function update(Request $request, Menu $menu, MenuItem $item): RedirectResponse
    {
        $item->updateOrFail($request->all()['item'] ?? []);

        return redirect()->back();
    }

    public function destroy(Request $request, Menu $menu, MenuItem $item): RedirectResponse
    {
        $item->deleteOrFail();

        return redirect()->back();
    }
}
