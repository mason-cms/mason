<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * List Users
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        if ($filters = $request->input('filters')) {
            $query->filter($filters);
        }

        $total = $query->count();

        $users = $query->paginate($perPage = $request->input('per_page') ?? 25);

        return response()->view('workshop.users.index', [
            'users' => $users,
            'total' => $total,
            'perPage' => $perPage,
            'filters' => $filters ?? null,
            'search' => $search ?? null,
        ]);
    }

    /**
     * Create User
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = new User;

        return response()->view('workshop.users.create', compact('user'));
    }

    /**
     * Store User
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $user = new User($request->all()['user'] ?? []);

        $user->saveOrFail();

        return redirect()->route('workshop.users.index');
    }

    /**
     * Show User
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, User $user)
    {
        return redirect()->route('workshop.users.edit', [$user]);
    }

    /**
     * Edit User
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {
        return response()->view('workshop.users.edit', compact('user'));
    }

    /**
     * Update User
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function update(Request $request, User $user)
    {
        $user->updateOrFail($request->all()['user'] ?? []);

        return redirect()->back();
    }

    /**
     * Destroy User
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function destroy(Request $request, User $user)
    {
        $user->deleteOrFail();

        return redirect()->route('workshop.users.index');
    }
}
