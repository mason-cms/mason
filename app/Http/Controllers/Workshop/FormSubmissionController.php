<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FormSubmissionController extends Controller
{
    public function index(Request $request, Form $form): Response
    {
        return response()->view('workshop.forms.submissions.index', [
            'request' => $request,
            'form' => $form,
            'submissions' => $form->submissions()->paginate($perPage = $request->input('per_page') ?? 25),
            'perPage' => $perPage,
        ]);
    }
}
