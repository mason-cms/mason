<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        $query = User::query();

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        if ($filters = $request->input('filters')) {
            $query->filter($filters);
        }

        return response()->view('workshop.users.index', [
            'request' => $request,
            'users' => $query->paginate($perPage = $request->input('per_page') ?? 25),
            'total' => $query->count(),
            'perPage' => $perPage,
            'filters' => $filters ?? null,
            'search' => $search ?? null,
        ]);
    }

    public function create(Request $request): Response
    {
        return response()->view('workshop.users.create', [
            'request' => $request,
            'user' => new User($request->all()['user'] ?? []),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = new User($request->all()['user'] ?? []);

        $user->saveOrFail();

        return redirect()->route('workshop.users.index');
    }

    public function show(Request $request, User $user): RedirectResponse
    {
        return redirect()->route('workshop.users.edit', [$user]);
    }

    public function edit(Request $request, User $user): Response
    {
        return response()->view('workshop.users.edit', [
            'request' => $request,
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $user->updateOrFail($request->all()['user'] ?? []);

        return redirect()->back();
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $user->deleteOrFail();

        return redirect()->route('workshop.users.index');
    }
}
