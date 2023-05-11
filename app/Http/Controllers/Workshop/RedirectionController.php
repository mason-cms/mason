<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\Redirection;
use Illuminate\Http\Request;

class RedirectionController extends Controller
{
    /**
     * List Redirections
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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

    /**
     * Create Redirection
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $redirection = new Redirection($request->all()['redirection'] ?? []);

        return response()->view('workshop.configuration.redirections.create', compact('redirection'));
    }

    /**
     * Store Redirection
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $redirection = new Redirection($request->all()['redirection'] ?? []);

        $redirection->saveOrFail();

        return redirect()->route('workshop.configuration.redirection.index');
    }

    /**
     * Edit Redirection
     *
     * @param Request $request
     * @param Redirection $redirection
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Redirection $redirection)
    {
        return response()->view('workshop.configuration.redirections.edit', compact('redirection'));
    }

    /**
     * Update Redirection
     *
     * @param Request $request
     * @param Redirection $redirection
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Redirection $redirection)
    {
        $redirection->updateOrFail($request->all()['redirection'] ?? []);

        return redirect()->route('workshop.configuration.redirection.index');
    }

    /**
     * Delete Redirection
     *
     * @param Request $request
     * @param Redirection $redirection
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function destroy(Request $request, Redirection $redirection)
    {
        $redirection->deleteOrFail();

        return redirect()->route('workshop.configuration.redirection.index');
    }
}
