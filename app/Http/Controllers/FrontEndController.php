<?php

namespace App\Http\Controllers;

use App\Models\Locale;
use App\Models\Redirection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class FrontEndController extends Controller
{
    protected $site;

    public function __construct()
    {
        $this->site = site();
    }

    /**
     * Show the home page
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $localeName
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function home(Request $request, string $localeName = null)
    {
        if (isset($localeName)) {
            if (Locale::isDefault($localeName)) {
                return redirect()->route('home');
            }

            $this->site->setLocale($localeName);
        }

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

    /**
     * Show a specified entry
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $params
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|void
     */
    public function entry(Request $request, ...$params)
    {
        if (isset($params[0]) && Locale::exists($params[0])) {
            $this->site->setLocale($localeName = $params[0]);
            $entryName = $params[1] ?? null;

            if (Locale::isDefault($localeName)) {
                return redirect()->route('entry', ['entry' => $entryName]);
            }
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

    /**
     * List entries for an entry type
     *
     * @param Request $request
     * @param ...$params
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|void
     */
    public function entryType(Request $request, ...$params)
    {
        if (isset($params[0]) && Locale::exists($params[0])) {
            $this->site->setLocale($localeName = $params[0]);
            $entryTypeName = $params[1] ?? null;

            if (Locale::isDefault($localeName)) {
                return redirect()->to('entryType', ['entryType' => $entryTypeName]);
            }
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

    /**
     * Show a specified taxonomy
     *
     * @param Request $request
     * @param ...$params
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|void
     */
    public function taxonomy(Request $request, ...$params)
    {
        if (isset($params[0]) && Locale::exists($params[0])) {
            $this->site->setLocale($localeName = $params[0]);
            $taxonomyTypeName = $params[1] ?? null;
            $taxonomyName = $params[2] ?? null;
            $entryTypeName = $params[3] ?? null;

            if (Locale::isDefault($localeName)) {
                return redirect()->route('taxonomy', [
                    'taxonomyType' => $taxonomyTypeName,
                    'taxonomy' => $taxonomyName,
                    'entryType' => $entryTypeName,
                ]);
            }
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

    public function redirect(Request $request, Redirection $redirection): RedirectResponse
    {
        $redirection->hits()->create();
        return $redirection->go();
    }

    public function upload(Request $request)
    {
        $uploaded = [];

        $files = $request->allFiles();

        foreach ($files as $fileGroup) {
            foreach ($fileGroup as $file) {
                if ($file instanceof UploadedFile) {
                    try {
                        if ($file->isValid()) {
                            $uuid = Uuid::uuid4();
                            $filename = $file->getClientOriginalName();

                            $storageKey = $file->storePubliclyAs(
                                "upload/{$uuid}",
                                $filename
                            );

                            if (isset($storageKey)) {
                                $url = Storage::url($storageKey);

                                if (isset($url)) {
                                    $uploaded[] = [
                                        'name' => $filename,
                                        'storageKey' => $storageKey,
                                        'url' => $url,
                                    ];
                                } else {
                                    throw new \Exception("Cannot get URL for: {$storageKey}");
                                }
                            } else {
                                throw new \Exception("Cannot store file: " . print_r($file, true));
                            }
                        } else {
                            throw new \Exception("Invalid file: " . print_r($file, true));
                        }
                    } catch (\Exception $e) {
                        \Sentry\captureException($e);
                    }
                }
            }
        }

        return response()->json($uploaded);
    }
}
