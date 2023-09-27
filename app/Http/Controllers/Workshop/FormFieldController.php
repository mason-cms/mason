<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormField;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FormFieldController extends Controller
{
    public function index(Request $request, Form $form): Response
    {
        return response()->view('workshop.forms.fields.index', [
            'request' => $request,
            'form' => $form,
            'fields' => $form->fields,
        ]);
    }

    public function create(Request $request, Form $form): Response
    {
        return response()->view('workshop.forms.fields.create', [
            'request' => $request,
            'form' => $form,
            'field' => $form->fields()->make($request->all()['field'] ?? []),
        ]);
    }

    public function store(Request $request, Form $form): RedirectResponse
    {
        $field = $form->fields()->make($request->all()['field'] ?? []);

        $field->saveOrFail();

        return redirect()->back();
    }

    public function edit(Request $request, Form $form, FormField $field): Response
    {
        return response()->view('workshop.forms.fields.edit', [
            'request' => $request,
            'form' => $form,
            'field' => $field,
        ]);
    }

    public function update(Request $request, Form $form, FormField $field): RedirectResponse
    {
        $field->updateOrFail($request->all()['field'] ?? []);

        return redirect()->back();
    }

    public function destroy(Request $request, Form $form, FormField $field): RedirectResponse
    {
        $field->deleteOrFail();

        return redirect()->back();
    }
}
