<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Locale;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function index(Request $request)
    {
        $query = Block::query();

        if ($request->get('location')) {
            $query->byLocation($request->get('location'));
        }

        if ($request->get('locale_id')) {
            $query->byLocale($request->get('locale_id'));
        }

        $blocks = $query->paginate($perPage = $request->input('per_page') ?? 25);

        return response()->view('workshop.blocks.index', [
            'request' => $request,
            'blockLocations' => site(false)->theme()->blockLocations(),
            'locales' => Locale::all(),
            'blocks' => $blocks,
            'total' => $query->count(),
            'perPage' => $perPage,
        ]);
    }

    public function create(Request $request)
    {
        $block = new Block($request->all());

        $block->saveOrFail();

        return redirect()->route('workshop.blocks.edit', [$block]);
    }

    public function store(Request $request)
    {
        $block = new Block($request->all());

        $block->saveOrFail();

        return redirect()->route('workshop.blocks.edit', [$block]);
    }

    public function edit(Request $request, Block $block)
    {
        return response()->view('workshop.blocks.edit', [
            'request' => $request,
            'block' => $block,
            'blockLocations' => site(false)->theme()->blockLocations(),
        ]);
    }

    public function update(Request $request, Block $block)
    {
        $block->updateOrFail($request->all()['block'] ?? []);

        return redirect()->back();
    }

    public function destroy(Request $request, Block $block)
    {
        $block->deleteOrFail();

        return redirect()->back();
    }
}
