<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class Localization
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
        // app()->setLocale($request->segment(1));
        // app()->setLocale($request->locale);

        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        } else if (auth()->user()->locale) {
            App::setLocale(auth()->user()->locale->short_sign);
        }
        return $next($request);
    }
}
