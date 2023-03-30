<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\Taxonomy;
use App\Models\TaxonomyType;
use App\Models\Locale;
use Illuminate\Http\Request;

class TaxonomyController extends Controller
{
    /**
     * List Taxonomies
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaxonomyType  $taxonomyType
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TaxonomyType $taxonomyType)
    {
        $query = Taxonomy::byType($taxonomyType)->topLevel();

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        if ($filters = $request->input('filters')) {
            $query->filter($filters);
        }

        $total = $query->count();

        $taxonomies = $query->paginate($perPage = $request->input('per_page') ?? 25);

        return response()->view('workshop.taxonomies.index', [
            'taxonomies' => $taxonomies,
            'total' => $total,
            'perPage' => $perPage,
            'taxonomyType' => $taxonomyType,
            'filters' => $filters ?? null,
            'search' => $search ?? null,
        ]);
    }

    /**
     * Create Taxonomy
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaxonomyType  $taxonomyType
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function create(Request $request, TaxonomyType $taxonomyType)
    {
        $taxonomy = new Taxonomy;
        $taxonomy->type()->associate($taxonomyType);
        $taxonomy->locale()->associate(Locale::getDefault());
        $taxonomy->saveOrFail();

        return redirect()->route('workshop.taxonomies.edit', [$taxonomyType, $taxonomy]);
    }

    /**
     * Show Taxonomy
     *
     * @param Request $request
     * @param TaxonomyType $taxonomyType
     * @param Taxonomy $taxonomy
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, TaxonomyType $taxonomyType, Taxonomy $taxonomy)
    {
        return redirect()->route('workshop.taxonomies.edit', [$taxonomyType, $taxonomy]);
    }

    /**
     * Edit Taxonomy
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaxonomyType  $taxonomyType
     * @param  \App\Models\Taxonomy  $taxonomy
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, TaxonomyType $taxonomyType, Taxonomy $taxonomy)
    {
        return response()->view('workshop.taxonomies.edit', compact('taxonomyType', 'taxonomy'));
    }

    /**
     * Update Taxonomy
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaxonomyType  $taxonomyType
     * @param  \App\Models\Taxonomy  $taxonomy
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function update(Request $request, TaxonomyType $taxonomyType, Taxonomy $taxonomy)
    {
        $taxonomy->updateOrFail($request->all()['taxonomy'] ?? []);

        if ($request->has('publish')) {
            $taxonomy->publish();
        }

        return redirect()->route('workshop.taxonomies.edit', [$taxonomyType, $taxonomy]);
    }

    /**
     * Destroy Taxonomy
     *
     * @param Request $request
     * @param TaxonomyType $taxonomyType
     * @param Taxonomy $taxonomy
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function destroy(Request $request, TaxonomyType $taxonomyType, Taxonomy $taxonomy)
    {
        $taxonomy->deleteOrFail();

        return redirect()->route('workshop.taxonomies.index', [$taxonomyType]);
    }
}
