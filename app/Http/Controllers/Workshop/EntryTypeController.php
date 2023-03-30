<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\EntryType;
use Illuminate\Http\Request;

class EntryTypeController extends Controller
{
    /**
     * List Entry Types
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = EntryType::query();

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        if ($filters = $request->input('filters')) {
            $query->filter($filters);
        }

        return response()->view('workshop.configuration.entry-types.index', [
            'entryTypes' => $query->paginate($perPage = $request->input('per_page') ?? 25),
            'total' => $query->count(),
            'perPage' => $perPage,
            'filters' => $filters ?? null,
            'search' => $search ?? null,
        ]);
    }

    /**
     * Create Entry Type
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $entryType = new EntryType($request->all()['entry_type'] ?? []);

        return response()->view('workshop.configuration.entry-types.create', compact('entryType'));
    }

    /**
     * Store Entry Type
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $entryType = new EntryType($request->all()['entry_type'] ?? []);

        $entryType->saveOrFail();

        return redirect()->route('workshop.configuration.entry-type.show', [$entryType]);
    }

    /**
     * Show Entry Type
     *
     * @param Request $request
     * @param EntryType $entryType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, EntryType $entryType)
    {
        return redirect()->route('workshop.configuration.entry-type.edit', [$entryType]);
    }

    /**
     * Edit Entry Type
     *
     * @param Request $request
     * @param EntryType $entryType
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, EntryType $entryType)
    {
        return response()->view('workshop.configuration.entry-types.edit', compact('entryType'));
    }

    /**
     * Update Entry Type
     *
     * @param Request $request
     * @param EntryType $entryType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, EntryType $entryType)
    {
        $entryType->updateOrFail($request->all()['entry_type'] ?? []);

        return redirect()->route('workshop.configuration.entry-type.index');
    }

    /**
     * Delete Entry Type
     *
     * @param Request $request
     * @param EntryType $entryType
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function destroy(Request $request, EntryType $entryType)
    {
        $entryType->deleteOrFail();

        return redirect()->route('workshop.configuration.entry-type.index');
    }
}
