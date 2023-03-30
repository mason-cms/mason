<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\Entry;
use App\Models\EntryType;
use App\Models\Locale;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    /**
     * List Entries
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EntryType  $entryType
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, EntryType $entryType)
    {
        $query = $entryType->entries();

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        if ($filters = $request->input('filters')) {
            $query->filter($filters);
        }

        $total = $query->count();

        $entries = $query->paginate($perPage = $request->input('per_page') ?? 25);

        return response()->view('workshop.entries.index', [
            'entries' => $entries,
            'total' => $total,
            'perPage' => $perPage,
            'entryType' => $entryType,
            'filters' => $filters ?? null,
            'search' => $search ?? null,
        ]);
    }

    /**
     * Create Entry
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EntryType  $entryType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request, EntryType $entryType)
    {
        $entry = $entryType->entries()->make();
        $entry->locale()->associate(Locale::getDefault());
        $entry->author()->associate($request->user());
        $entry->saveOrFail();

        return redirect()->route('workshop.entries.edit', [$entryType, $entry]);
    }

    /**
     * Show Entry
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EntryType  $entryType
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, EntryType $entryType, Entry $entry)
    {
        return redirect()->route('workshop.entries.edit', [$entryType, $entry]);
    }

    /**
     * Edit Entry
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EntryType  $entryType
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, EntryType $entryType, Entry $entry)
    {
        return response()->view('workshop.entries.edit', compact('entryType', 'entry'));
    }

    /**
     * Update Entry
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EntryType  $entryType
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, EntryType $entryType, Entry $entry)
    {
        $entry->updateOrFail($request->all()['entry'] ?? []);

        if ($request->has('publish')) {
            $entry->publish();
        }

        return redirect()->back();
    }

    /**
     * Delete Entry
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EntryType  $entryType
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, EntryType $entryType, Entry $entry)
    {
        $entry->deleteOrFail();

        return redirect()->route('workshop.entries.index', [$entryType]);
    }
}
