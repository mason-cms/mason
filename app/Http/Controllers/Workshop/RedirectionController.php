<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\Redirection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RedirectionController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Redirection::query();

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        return response()->view('workshop.configuration.redirections.index', [
            'redirections' => $query->paginate($perPage = $request->input('per_page') ?? 25),
            'total' => $query->count(),
            'perPage' => $perPage,
            'filters' => $filters ?? null,
            'search' => $search ?? null,
        ]);
    }

    public function create(Request $request): Response
    {
        return response()->view('workshop.configuration.redirections.create', [
            'request' => $request,
            'redirection' => new Redirection($request->all()['redirection'] ?? []),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $redirection = new Redirection($request->all()['redirection'] ?? []);

        $redirection->saveOrFail();

        return redirect()->route('workshop.configuration.redirection.index');
    }

    public function edit(Request $request, Redirection $redirection): Response
    {
        return response()->view('workshop.configuration.redirections.edit', [
            'request' => $request,
            'redirection' => $redirection,
        ]);
    }

    public function update(Request $request, Redirection $redirection): RedirectResponse
    {
        $redirection->updateOrFail($request->all()['redirection'] ?? []);

        return redirect()->route('workshop.configuration.redirection.index');
    }

    public function destroy(Request $request, Redirection $redirection): RedirectResponse
    {
        $redirection->deleteOrFail();

        return redirect()->route('workshop.configuration.redirection.index');
    }
}
