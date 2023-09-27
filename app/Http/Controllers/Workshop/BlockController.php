<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Locale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlockController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Block::query();

        if ($request->get('location')) {
            $query->byLocation($request->get('location'));
        }

        if ($request->get('locale_id')) {
            $query->byLocale($request->get('locale_id'));
        }

        return response()->view('workshop.blocks.index', [
            'request' => $request,
            'blockLocations' => site(false)->theme()->blockLocations(),
            'locales' => Locale::all(),
            'blocks' => $query->paginate($perPage = $request->input('per_page') ?? 25),
            'total' => $query->count(),
            'perPage' => $perPage,
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $block = new Block($request->all());

        $block->saveOrFail();

        return redirect()->route('workshop.blocks.edit', [$block]);
    }

    public function store(Request $request): RedirectResponse
    {
        $block = new Block($request->all());

        $block->saveOrFail();

        return redirect()->route('workshop.blocks.edit', [$block]);
    }

    public function edit(Request $request, Block $block): Response
    {
        return response()->view('workshop.blocks.edit', [
            'request' => $request,
            'block' => $block,
            'blockLocations' => site(false)->theme()->blockLocations(),
        ]);
    }

    public function update(Request $request, Block $block): RedirectResponse
    {
        $block->updateOrFail($request->all()['block'] ?? []);

        return redirect()->back();
    }

    public function destroy(Request $request, Block $block): RedirectResponse
    {
        $block->deleteOrFail();

        return redirect()->back();
    }
}
