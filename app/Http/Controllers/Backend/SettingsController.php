<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Display Settings
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->view('backend.configuration.settings.index', [
            'settings' => site(false)->theme()->settings(),
        ]);
    }

    public function update(Request $request)
    {
        $requestInput = $request->all();

        $settings = site(false)->theme()->settings();

        foreach ($settings as $setting) {
            if (isset($setting->name) && array_key_exists($setting->name, $requestInput['settings'])) {
                $value = $requestInput['settings'][$setting->name];

                if ($value instanceof UploadedFile) {
                    $value = Storage::disk('public')->put('/', $value, 'public');
                }

                Setting::set($setting->name, $value);
            }
        }

        return redirect()->route('backend.configuration.setting.index');
    }
}
