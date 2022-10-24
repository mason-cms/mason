<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ConfigurationController extends Controller
{
    const ICON = 'fa-screwdriver-wrench';

    /**
     * General
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function general(Request $request)
    {
        return view('backend.configuration.general', [
            'fields' => $this->getFields(),
        ]);
    }

    /**
     * Update Configuration
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $configuration = $request->all()['configuration'] ?? [];

        $oldTheme = env('SITE_THEME');

        $env = [];

        foreach ($this->getFields() as $field) {
            $fieldName = $field['name'];

            if (array_key_exists($fieldName, $configuration)) {
                $value = $configuration[$fieldName];

                switch ($field['type']) {
                    case 'boolean':
                        $env[$fieldName] = isset($value) ? !! $value : null;
                        break;

                    default:
                        $env[$fieldName] = "{$value}";
                        break;
                }
            }
        }

        setEnv($env);

        $newTheme = env('SITE_THEME');

        if ($newTheme !== $oldTheme) {
            Artisan::call('mason:theme:install');
        }

        return redirect()->route('backend.configuration.general');
    }

    /**
     * Update App
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateApp(Request $request)
    {
        Artisan::call('mason:update --deploy');

        return redirect()->back();
    }

    /**
     * Update Theme
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateTheme(Request $request)
    {
        Artisan::call('mason:theme:update');

        return redirect()->back();
    }

    protected function getFields()
    {
        return [
            [
                'name' => 'SITE_NAME',
                'label' => __('configuration.general.fields.siteName.label'),
                'type' => 'text',
                'required' => true,
                'value' => env('SITE_NAME'),
            ],

            [
                'name' => 'SITE_DESCRIPTION',
                'label' => __('configuration.general.fields.siteDescription.label'),
                'type' => 'text',
                'required' => true,
                'value' => env('SITE_DESCRIPTION'),
            ],

            [
                'name' => 'SITE_THEME',
                'label' => __('configuration.general.fields.siteTheme.label'),
                'type' => 'text',
                'required' => true,
                'value' => env('SITE_THEME'),
            ],

            [
                'name' => 'SITE_ALLOW_USER_REGISTRATION',
                'label' => __('configuration.general.fields.siteAllowUserRegistration.label'),
                'type' => 'boolean',
                'required' => true,
                'value' => env('SITE_ALLOW_USER_REGISTRATION'),
            ],

            [
                'name' => 'SITE_RESTRICT_USER_EMAIL_DOMAIN',
                'label' => __('configuration.general.fields.siteRestrictUserEmailDomain.label'),
                'type' => 'boolean',
                'required' => true,
                'value' => env('SITE_RESTRICT_USER_EMAIL_DOMAIN'),
            ],

            [
                'name' => 'SITE_ALLOWED_USER_EMAIL_DOMAINS',
                'label' => __('configuration.general.fields.siteAllowedUserEmailDomains.label'),
                'type' => 'text',
                'required' => false,
                'value' => env('SITE_ALLOWED_USER_EMAIL_DOMAINS'),
            ],
        ];
    }
}
