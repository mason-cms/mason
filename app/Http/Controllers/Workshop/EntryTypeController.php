<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\EntryType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EntryTypeController extends Controller
{
    public function index(Request $request): Response
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

    public function create(Request $request): Response
    {
        return response()->view('workshop.configuration.entry-types.create', [
            'entryType' => new EntryType($request->all()['entry_type'] ?? []),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $entryType = new EntryType($request->all()['entry_type'] ?? []);

        $entryType->saveOrFail();

        return redirect()->route('workshop.configuration.entry-type.show', [$entryType]);
    }

    public function show(Request $request, EntryType $entryType): RedirectResponse
    {
        return redirect()->route('workshop.configuration.entry-type.edit', [$entryType]);
    }

    public function edit(Request $request, EntryType $entryType): Response
    {
        return response()->view('workshop.configuration.entry-types.edit', [
            'entryType' => $entryType,
        ]);
    }

    public function update(Request $request, EntryType $entryType): RedirectResponse
    {
        $entryType->updateOrFail($request->all()['entry_type'] ?? []);

        return redirect()->route('workshop.configuration.entry-type.index');
    }

    public function destroy(Request $request, EntryType $entryType): RedirectResponse
    {
        $entryType->deleteOrFail();

        return redirect()->route('workshop.configuration.entry-type.index');
    }
}
