<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Locale;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /**
     * List Locales
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Locale::query();

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        if ($filters = $request->input('filters')) {
            $query->filter($filters);
        }

        return response()->view('backend.configuration.locales.index', [
            'locales' => $query->paginate($perPage = $request->input('per_page') ?? 25),
            'total' => $query->count(),
            'perPage' => $perPage,
            'filters' => $filters ?? null,
            'search' => $search ?? null,
        ]);
    }

    /**
     * Create Locale
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $locale = new Locale($request->all()['locale'] ?? []);

        return response()->view('backend.configuration.locales.create', compact('locale'));
    }

    /**
     * Store Locale
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $locale = new Locale($request->all()['locale'] ?? []);

        $locale->saveOrFail();

        return redirect()->route('backend.configuration.locale.show', [$locale]);
    }

    /**
     * Show Locale
     *
     * @param Request $request
     * @param Locale $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, Locale $locale)
    {
        return redirect()->route('backend.configuration.locale.edit', [$locale]);
    }

    /**
     * Edit Locale
     *
     * @param Request $request
     * @param Locale $locale
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Locale $locale)
    {
        return response()->view('backend.configuration.locales.edit', compact('locale'));
    }

    /**
     * Update Locale
     *
     * @param Request $request
     * @param Locale $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Locale $locale)
    {
        $locale->updateOrFail($request->all()['locale'] ?? []);

        return redirect()->route('backend.configuration.locale.index');
    }

    /**
     * Delete Locale
     *
     * @param Request $request
     * @param Locale $locale
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function destroy(Request $request, Locale $locale)
    {
        $locale->deleteOrFail();

        return redirect()->route('backend.configuration.locale.index');
    }
}
