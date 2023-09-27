<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\Locale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LocaleController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Locale::query();

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        if ($filters = $request->input('filters')) {
            $query->filter($filters);
        }

        return response()->view('workshop.configuration.locales.index', [
            'locales' => $query->paginate($perPage = $request->input('per_page') ?? 25),
            'total' => $query->count(),
            'perPage' => $perPage,
            'filters' => $filters ?? null,
            'search' => $search ?? null,
        ]);
    }

    public function create(Request $request): Response
    {
        return response()->view('workshop.configuration.locales.create', [
            'locale' => new Locale($request->all()['locale'] ?? []),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $locale = new Locale($request->all()['locale'] ?? []);

        $locale->saveOrFail();

        return redirect()->route('workshop.configuration.locale.show', [$locale]);
    }

    public function show(Request $request, Locale $locale): RedirectResponse
    {
        return redirect()->route('workshop.configuration.locale.edit', [$locale]);
    }

    public function edit(Request $request, Locale $locale): Response
    {
        return response()->view('workshop.configuration.locales.edit', [
            'locale' => $locale,
        ]);
    }

    public function update(Request $request, Locale $locale): RedirectResponse
    {
        $locale->updateOrFail($request->all()['locale'] ?? []);

        return redirect()->route('workshop.configuration.locale.index');
    }

    public function destroy(Request $request, Locale $locale): RedirectResponse
    {
        $locale->deleteOrFail();

        return redirect()->route('workshop.configuration.locale.index');
    }
}
