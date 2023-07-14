<?php

namespace App\Http\Middleware;

use App\Models\Locale;
use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $path = $request->path();
        $parts = explode("/", $path);

        $defaultLocale = Locale::getDefault();
        $localeNames = Locale::all()->pluck('name');

        if (isset($parts[0]) && $localeNames->contains($parts[0])) {
            $locale = Locale::findByName($parts[0]);

            if ($locale->is($defaultLocale)) {
                unset($parts[0]);
                $cleanPath = implode("/", $parts);
                return redirect()->to("/$cleanPath");
            }
        }

        site()->setLocale($locale ?? $defaultLocale);

        return $next($request);
    }
}
