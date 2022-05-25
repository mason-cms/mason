<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Taxonomy;
use App\Models\TaxonomyType;
use App\Models\Locale;
use Illuminate\Http\Request;

class TaxonomyController extends Controller
{
    /**
     * Display taxonomies.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaxonomyType  $taxonomyType
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TaxonomyType $taxonomyType)
    {
        $query = Taxonomy::byType($taxonomyType);

        $query->whereNull('parent_id');

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        if ($filters = $request->input('filters')) {
            $query->filter($filters);
        }

        $total = $query->count();

        $taxonomies = $query->paginate($perPage = $request->input('per_page') ?? 25);

        return response()->view('backend.taxonomies.index', [
            'taxonomies' => $taxonomies,
            'total' => $total,
            'perPage' => $perPage,
            'taxonomyType' => $taxonomyType,
            'filters' => $filters ?? null,
            'search' => $search ?? null,
        ]);
    }

    /**
     * Show the form for creating a new taxonomy.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaxonomyType  $taxonomyType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request, TaxonomyType $taxonomyType)
    {
        $taxonomy = new Taxonomy;
        $taxonomy->type()->associate($taxonomyType);
        $taxonomy->locale()->associate(Locale::default());
        $taxonomy->save();

        return redirect()->route('backend.taxonomies.edit', [$taxonomyType, $taxonomy]);
    }

    /**
     * Display the specified taxonomy.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaxonomyType  $taxonomyType
     * @param  \App\Models\Taxonomy  $taxonomy
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, TaxonomyType $taxonomyType, Taxonomy $taxonomy)
    {
        //
    }

    /**
     * Show the form for editing the specified taxonomy.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaxonomyType  $taxonomyType
     * @param  \App\Models\Taxonomy  $taxonomy
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, TaxonomyType $taxonomyType, Taxonomy $taxonomy)
    {
        return response()->view('backend.taxonomies.edit', compact('taxonomyType', 'taxonomy'));
    }

    /**
     * Update the specified taxonomy in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaxonomyType  $taxonomyType
     * @param  \App\Models\Taxonomy  $taxonomy
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, TaxonomyType $taxonomyType, Taxonomy $taxonomy)
    {
        $requestInput = $request->all();

        $taxonomy->update($requestInput['taxonomy'] ?? []);

        if ($request->has('publish')) {
            $taxonomy->publish();
        }

        return redirect()->route('backend.taxonomies.edit', [$taxonomyType, $taxonomy]);
    }

    /**
     * Remove the specified taxonomy from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaxonomyType  $taxonomyType
     * @param  \App\Models\Taxonomy  $taxonomy
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, TaxonomyType $taxonomyType, Taxonomy $taxonomy)
    {
        $taxonomy->delete();

        return redirect()->route('backend.taxonomies.index', [$taxonomyType]);
    }
}
