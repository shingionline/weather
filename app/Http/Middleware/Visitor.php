<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Helpers;
use App\Models\ProductView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Visitor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            $agent   = Helpers::getAgent();
            $ip      = Helpers::getIpAddress();
            $ipinfo  = Helpers::getIpInfo($ip);
            $code    = $ipinfo->code ?? null;
            $country = Helpers::getCountryByCode($code);
            $city    = (isset($ipinfo->city)) ? $ipinfo->city : null;
            $human   = $request->cookie('human');

            if ($human && $code && $country && $city) {
                ProductView::firstOrCreate([
                'product_id' => $request->id,
                'ip'         => $ip,
                'country'    => $country,
                'city'       => $city,
                'agent'      => $agent,
                ]);
            }
        }
        
        return $next($request);
    }
}
