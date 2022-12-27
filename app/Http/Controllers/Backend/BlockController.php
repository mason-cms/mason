<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Block;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function index(Request $request)
    {
        $site = site(false);
        $theme = $site->theme();
        $blockLocations = $theme->blockLocations();

        dd($blockLocations);

        $query = Block::query();

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        if ($filters = $request->input('filters')) {
            $query->filter($filters);
        }

        $total = $query->count();

        $blocks = $query->paginate($perPage = $request->input('per_page') ?? 25);

        return response()->view('backend.blocks.index', [
            'blocks' => $blocks,
            'total' => $total,
            'perPage' => $perPage,
            'filters' => $filters ?? null,
            'search' => $search ?? null,
        ]);
    }
}
