<?php

namespace App\Http\Controllers\Backend;

use App\Models\Medium;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MediumController extends Controller
{
    /**
     * List Media
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Medium::query();

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        if ($filters = $request->input('filters')) {
            $query->filter($filters);
        }

        $total = $query->count();

        $media = $query->paginate($perPage = $request->input('per_page') ?? 25);

        return response()->view('backend.media.index', [
            'media' => $media,
            'total' => $total,
            'perPage' => $perPage,
            'filters' => $filters ?? null,
            'search' => $search ?? null,
        ]);
    }

    /**
     * Create Medium
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $medium = new Medium($request->all()['medium'] ?? []);

        return response()->view('backend.media.create', [
            'medium' => $medium,
        ]);
    }

    /**
     * Store Medium
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $medium = new Medium($request->all()['medium'] ?? []);

        $medium->saveOrFail();

        return redirect()->route('backend.medium.index');
    }

    /**
     * Show Medium
     *
     * @param Request $request
     * @param Medium $media
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function show(Request $request, Medium $medium)
    {
        if (isset($medium->url)) {
            return redirect()->to($medium->url);
        }

        abort(404);
    }

    public function destroy(Request $request, Medium $medium)
    {
        $medium->deleteOrFail();

        return redirect()->route('backend.medium.index');
    }
}
