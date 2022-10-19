<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $site = site(false);
        $settings = $site->theme()->settings();

        return response()->view('backend.configuration.settings.index', compact('settings'));
    }
}
