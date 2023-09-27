<?php

namespace App\Http\Controllers\Workshop;

use App\Models\Medium;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class MediumController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Medium::query();

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        if ($filters = $request->input('filters')) {
            $query->filter($filters);
        }

        return response()->view('workshop.media.index', [
            'media' => $query->paginate($perPage = $request->input('per_page') ?? 25),
            'total' => $query->count(),
            'perPage' => $perPage,
            'filters' => $filters ?? null,
            'search' => $search ?? null,
        ]);
    }

    public function create(Request $request): Response
    {
        return response()->view('workshop.media.create', [
            'request' => $request,
            'medium' => new Medium($request->all()['medium'] ?? []),
        ]);
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $media = collect();

        foreach ($request->file('files') as $file) {
            $medium = new Medium([
                'file' => $file,
            ]);

            $medium->saveOrFail();

            $media->push($media);
        }

        if ($request->expectsJson()) {
            return response()->json($media);
        }

        return redirect()->route('workshop.medium.index');
    }

    public function show(Request $request, Medium $medium): RedirectResponse|JsonResponse|null
    {
        if ($request->expectsJson()) {
            return response()->json($medium);
        }

        if (isset($medium->url)) {
            return redirect()->to($medium->url);
        }

        abort(404);
    }

    public function destroy(Request $request, Medium $medium): RedirectResponse
    {
        $medium->deleteOrFail();

        return redirect()->route('workshop.medium.index');
    }
}
