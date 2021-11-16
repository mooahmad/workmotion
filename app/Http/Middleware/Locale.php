<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class Locale
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $default = config('app.locale');
        $segment = $request->segment(1);

        if (in_array($segment, config('app.locales'))) {
            $default = $segment;
        }
        App::setLocale($default);

        return $next($request);
    }


}
