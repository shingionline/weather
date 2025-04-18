<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Human
{
    public function handle(Request $request, Closure $next): Response
    {
        $agent  = Helpers::getAgent();
        $isBot  = Helpers::isBot($agent);
        $redirectPage = cookie('redirect', $request->fullUrl(), 60);
        $existingCookie = $request->cookie('human');

        // let bots through
        if ($isBot) { return $next($request); }

        // let humans through
        return (!$existingCookie) ? redirect('/security')->withCookie($redirectPage) : $next($request);
    }
}
