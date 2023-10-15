<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Locale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FormController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Form::query();

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        if ($filters = $request->input('filters')) {
            $query->filter($filters);
        }

        $total = $query->count();

        return response()->view('workshop.forms.index', [
            'request' => $request,
            'forms' => $query->paginate($perPage = $request->input('per_page') ?? 25),
            'locales' => Locale::all(),
            'total' => $total,
            'perPage' => $perPage,
            'filters' => $filters ?? null,
            'search' => $search ?? null,
            'newForm' => new Form,
        ]);
    }

    public function create(Request $request): Response
    {
        return response()->view('workshop.forms.create', [
            'request' => $request,
            'form' => new Form($request->all()['form'] ?? []),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $form = new Form($request->all()['form'] ?? []);

        $form->saveOrFail();

        return redirect()->route('workshop.forms.edit', [$form]);
    }

    public function edit(Request $request, Form $form): Response
    {
        return response()->view('workshop.forms.edit', [
            'request' => $request,
            'form' => $form,
        ]);
    }

    public function addField(Request $request, Form $form): Response
    {
        $requestInput = $request->all();

        return response()->view('workshop.forms.addField', [
            'request' => $request,
            'form' => $form,
            'field' => $form->fields()->create($requestInput['field'] ?? []),
        ]);
    }

    public function update(Request $request, Form $form): RedirectResponse
    {
        $requestInput = $request->all();

        $form->updateOrFail($requestInput['form'] ?? []);

        return redirect()->back();
    }

    public function destroy(Request $request, Form $form): RedirectResponse
    {
        $form->deleteOrFail();

        return redirect()->back();
    }
}
