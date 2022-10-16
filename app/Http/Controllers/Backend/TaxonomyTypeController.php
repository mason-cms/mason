<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TaxonomyType;
use Illuminate\Http\Request;

class TaxonomyTypeController extends Controller
{
    /**
     * List Taxonomy Types
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = TaxonomyType::query();

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        if ($filters = $request->input('filters')) {
            $query->filter($filters);
        }

        return response()->view('backend.configuration.taxonomy-types.index', [
            'taxonomyTypes' => $query->paginate($perPage = $request->input('per_page') ?? 25),
            'total' => $query->count(),
            'perPage' => $perPage,
            'filters' => $filters ?? null,
            'search' => $search ?? null,
        ]);
    }

    /**
     * Create Taxonomy Type
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $requestInput = $request->all();

        $taxonomyType = new TaxonomyType($requestInput['taxonomy_type'] ?? []);

        return response()->view('backend.configuration.taxonomy-types.create', compact('taxonomyType'));
    }

    /**
     * Store Taxonomy Type
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $requestInput = $request->all();

        $taxonomyType = new TaxonomyType($requestInput['taxonomy_type'] ?? []);

        $taxonomyType->saveOrFail();

        return redirect()->route('backend.configuration.taxonomy-type.show', [$taxonomyType]);
    }

    /**
     * Show Taxonomy Type
     *
     * @param Request $request
     * @param TaxonomyType $taxonomyType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, TaxonomyType $taxonomyType)
    {
        return redirect()->route('backend.configuration.taxonomy-type.edit', [$taxonomyType]);
    }

    /**
     * Edit Taxonomy Type
     *
     * @param Request $request
     * @param TaxonomyType $taxonomyType
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, TaxonomyType $taxonomyType)
    {
        return response()->view('backend.configuration.taxonomy-types.edit', compact('taxonomyType'));
    }

    /**
     * Update Taxonomy Type
     *
     * @param Request $request
     * @param TaxonomyType $taxonomyType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, TaxonomyType $taxonomyType)
    {
        $requestInput = $request->all();

        $taxonomyType->updateOrFail($requestInput['taxonomy_type'] ?? []);

        return redirect()->route('backend.configuration.taxonomy-type.index');
    }

    /**
     * Delete Taxonomy Type
     *
     * @param Request $request
     * @param TaxonomyType $taxonomyType
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function destroy(Request $request, TaxonomyType $taxonomyType)
    {
        $taxonomyType->deleteOrFail();

        return redirect()->route('backend.configuration.taxonomy-type.index');
    }
}
