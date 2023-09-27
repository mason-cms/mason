<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\TaxonomyType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaxonomyTypeController extends Controller
{
    public function index(Request $request): Response
    {
        $query = TaxonomyType::query();

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        if ($filters = $request->input('filters')) {
            $query->filter($filters);
        }

        return response()->view('workshop.configuration.taxonomy-types.index', [
            'request' => $request,
            'taxonomyTypes' => $query->paginate($perPage = $request->input('per_page') ?? 25),
            'total' => $query->count(),
            'perPage' => $perPage,
            'filters' => $filters ?? null,
            'search' => $search ?? null,
        ]);
    }

    public function create(Request $request): Response
    {
        return response()->view('workshop.configuration.taxonomy-types.create', [
            'request' => $request,
            'taxonomyType' => new TaxonomyType($request->all()['taxonomy_type'] ?? []),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $taxonomyType = new TaxonomyType($request->all()['taxonomy_type'] ?? []);

        $taxonomyType->saveOrFail();

        return redirect()->route('workshop.configuration.taxonomy-type.show', [$taxonomyType]);
    }

    public function show(Request $request, TaxonomyType $taxonomyType): RedirectResponse
    {
        return redirect()->route('workshop.configuration.taxonomy-type.edit', [$taxonomyType]);
    }

    public function edit(Request $request, TaxonomyType $taxonomyType): Response
    {
        return response()->view('workshop.configuration.taxonomy-types.edit', [
            'request' => $request,
            'taxonomyType' => $taxonomyType,
        ]);
    }

    public function update(Request $request, TaxonomyType $taxonomyType): RedirectResponse
    {
        $taxonomyType->updateOrFail($request->all()['taxonomy_type'] ?? []);

        return redirect()->route('workshop.configuration.taxonomy-type.index');
    }

    public function destroy(Request $request, TaxonomyType $taxonomyType): RedirectResponse
    {
        $taxonomyType->deleteOrFail();

        return redirect()->route('workshop.configuration.taxonomy-type.index');
    }
}
