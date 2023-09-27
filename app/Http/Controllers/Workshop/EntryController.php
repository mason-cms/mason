<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\Entry;
use App\Models\EntryType;
use App\Models\Locale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EntryController extends Controller
{
    public function index(Request $request, EntryType $entryType): Response
    {
        $query = $entryType->entries();

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        if ($filters = $request->input('filters')) {
            $query->filter($filters);
        }

        $total = $query->count();

        return response()->view('workshop.entries.index', [
            'entries' => $query->paginate($perPage = $request->input('per_page') ?? 25),
            'total' => $total,
            'perPage' => $perPage,
            'entryType' => $entryType,
            'filters' => $filters ?? null,
            'search' => $search ?? null,
        ]);
    }

    public function create(Request $request, EntryType $entryType): RedirectResponse
    {
        $entry = $entryType->entries()->make();
        $entry->locale()->associate(Locale::getDefault());
        $entry->author()->associate($request->user());
        $entry->saveOrFail();

        return redirect()->route('workshop.entries.edit', [$entryType, $entry]);
    }

    public function show(Request $request, EntryType $entryType, Entry $entry): RedirectResponse
    {
        return redirect()->route('workshop.entries.edit', [$entryType, $entry]);
    }

    public function edit(Request $request, EntryType $entryType, Entry $entry): Response
    {
        return response()->view('workshop.entries.edit', [
            'entryType' => $entryType,
            'entry' => $entry,
        ]);
    }

    public function update(Request $request, EntryType $entryType, Entry $entry): RedirectResponse
    {
        $entry->updateOrFail($request->all()['entry'] ?? []);

        if ($request->has('publish')) {
            $entry->publish();
        }

        return redirect()->back();
    }

    public function destroy(Request $request, EntryType $entryType, Entry $entry): RedirectResponse
    {
        $entry->deleteOrFail();

        return redirect()->route('workshop.entries.index', [$entryType]);
    }
}
