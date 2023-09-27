<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\Taxonomy;
use App\Models\TaxonomyType;
use App\Models\Locale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaxonomyController extends Controller
{
    public function index(Request $request, TaxonomyType $taxonomyType): Response
    {
        $query = Taxonomy::byType($taxonomyType)->topLevel();

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        if ($filters = $request->input('filters')) {
            $query->filter($filters);
        }

        $total = $query->count();

        return response()->view('workshop.taxonomies.index', [
            'taxonomies' => $query->paginate($perPage = $request->input('per_page') ?? 25),
            'total' => $total,
            'perPage' => $perPage,
            'taxonomyType' => $taxonomyType,
            'filters' => $filters ?? null,
            'search' => $search ?? null,
        ]);
    }

    public function create(Request $request, TaxonomyType $taxonomyType): RedirectResponse
    {
        $taxonomy = new Taxonomy;
        $taxonomy->type()->associate($taxonomyType);
        $taxonomy->locale()->associate(Locale::getDefault());
        $taxonomy->saveOrFail();

        return redirect()->route('workshop.taxonomies.edit', [$taxonomyType, $taxonomy]);
    }

    public function show(Request $request, TaxonomyType $taxonomyType, Taxonomy $taxonomy): RedirectResponse
    {
        return redirect()->route('workshop.taxonomies.edit', [$taxonomyType, $taxonomy]);
    }

    public function edit(Request $request, TaxonomyType $taxonomyType, Taxonomy $taxonomy): Response
    {
        return response()->view('workshop.taxonomies.edit', [
            'request' => $request,
            'taxonomyType' => $taxonomyType,
            'taxonomy' => $taxonomy,
        ]);
    }

    public function update(Request $request, TaxonomyType $taxonomyType, Taxonomy $taxonomy): RedirectResponse
    {
        $taxonomy->updateOrFail($request->all()['taxonomy'] ?? []);

        if ($request->has('publish')) {
            $taxonomy->publish();
        }

        return redirect()->route('workshop.taxonomies.edit', [$taxonomyType, $taxonomy]);
    }

    public function destroy(Request $request, TaxonomyType $taxonomyType, Taxonomy $taxonomy): RedirectResponse
    {
        $taxonomy->deleteOrFail();

        return redirect()->route('workshop.taxonomies.index', [$taxonomyType]);
    }
}
