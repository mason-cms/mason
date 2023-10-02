<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Locale;
use App\Models\Redirection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FrontEndController extends Controller
{
    protected $site;

    public function __construct()
    {
        $this->site = site();
    }

    protected function boot(): void
    {
        $this->site->theme()->boot();
    }

    public function home(Request $request, ...$params): ?Response
    {
        $this->boot();

        $homePage = $this->site->homePage();

        $views = [
            "{$this->site->locale->name}/home",
            "home",
            $homePage?->view(),
        ];

        foreach ($views as $view) {
            if (isset($view) && view()->exists($view)) {
                return response()->view($view, [
                    'site' => $this->site,
                    'entry' => $homePage,
                    'translations' => $homePage?->translations,
                ]);
            }
        }

        abort(404);
    }

    public function entry(Request $request, ...$params): ?Response
    {
        $this->boot();

        if (isset($params[0]) && Locale::exists($params[0])) {
            $entryName = $params[1] ?? null;
        } else {
            $entryName = $params[0] ?? null;
        }

        if (isset($entryName) && $entry = $this->site->entry($entryName)) {
            if ($view = $entry->view()) {
                return response()->view($view, [
                    'site' => $this->site,
                    'entry' => $entry,
                    'translations' => $entry->translations,
                ]);
            }
        }

        abort(404);
    }

    public function entryType(Request $request, ...$params): ?Response
    {
        $this->boot();

        if (isset($params[0]) && Locale::exists($params[0])) {
            $entryTypeName = $params[1] ?? null;
        } else {
            $entryTypeName = $params[0] ?? null;
        }

        if (isset($entryTypeName) && $entryType = $this->site->entryType($entryTypeName)) {
            if ($view = $entryType->view()) {
                return response()->view($view, [
                    'site' => $this->site,
                    'entryType' => $entryType,
                    'entries' => $this->site->entries($entryType),
                ]);
            }
        }

        abort(404);
    }

    public function taxonomy(Request $request, ...$params): ?Response
    {
        $this->boot();

        if (isset($params[0]) && Locale::exists($params[0])) {
            $taxonomyTypeName = $params[1] ?? null;
            $taxonomyName = $params[2] ?? null;
            $entryTypeName = $params[3] ?? null;
        } else {
            $taxonomyTypeName = $params[0] ?? null;
            $taxonomyName = $params[1] ?? null;
            $entryTypeName = $params[2] ?? null;
        }

        if (isset($taxonomyTypeName) && $taxonomyType = $this->site->taxonomyType(name: $taxonomyTypeName)) {
            if (isset($taxonomyName) && $taxonomy = $this->site->taxonomy(name: $taxonomyName, type: $taxonomyType)) {
                $entries = $taxonomy->entries();

                if (isset($entryTypeName) && $entryType = $this->site->entryType($entryTypeName)) {
                    $entries->byType($entryType);
                }

                if ($view = $taxonomy->view()) {
                    return response()->view($view, [
                        'site' => $this->site,
                        'taxonomyType' => $this->site->taxonomyType($taxonomyTypeName),
                        'taxonomy' => $taxonomy,
                        'translations' => $taxonomy->translations,
                        'entryType' => $entryType ?? null,
                        'entries' => $entries,
                    ]);
                }
            }
        }

        abort(404);
    }

    public function formSubmit(Request $request, Form $form): RedirectResponse
    {
        $this->boot();

        $request->validate($form->rules);

        $submission = $form->submissions()->make()->fill([
            'input' => $request->all(),
            'user_agent' => $request->userAgent(),
            'user_ip' => $request->ip(),
            'referrer_url' => $request->header('referer'),
        ]);

        $submission->saveOrFail();

        $submission->verify();

        $submission->runActions();

        $success = $form->confirmation_message ?? __('forms.actions.submit.success');

        return redirect()->back()->with('success', $success);
    }

    public function redirect(Request $request, Redirection $redirection): RedirectResponse
    {
        $this->boot();

        $redirection->hits()->create();

        return $redirection->go();
    }
}
