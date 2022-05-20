<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function setLocale($locale = null)
    {
        $locale ??= config('app.locale');
        setlocale(LC_ALL, $locale);
        App::setLocale($locale);
        Carbon::setLocale($locale);
    }

    public function home(Request $request, $locale = null)
    {
        $this->setLocale($locale);

        if (view()->exists('home')) {
            return view('home', compact('locale'));
        } elseif ($homePageId = Setting::get('home_page_id')) {
            if ($page = Page::find($homePageId)) {
                return view('page', compact('locale', 'page'));
            }
        }
    }

    public function page(Request $request, $locale = null, Page $page)
    {
        $this->setLocale($locale);

        if (view()->exists('pages.' . $page->name)) {
            return view('pages.' . $page->name, compact('locale', 'page'));
        } else {
            return view('page', compact('locale', 'page'));
        }
    }

    public function post(Request $request, $locale = null, Post $post)
    {
        $this->setLocale($locale);

        if (view()->exists('posts.' . $post->name)) {
            return view('posts.' . $post->name, compact('locale', 'post'));
        } else {
            return view('post', compact('locale', 'post'));
        }
    }
}
