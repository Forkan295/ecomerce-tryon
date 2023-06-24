<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Closure;

class IdentifyTenant extends Middleware
{
    public function handle(Request $request, Closure $next)
    {
        $identifier = $request->route('tenant');
        $tenant     = Tenant::where('domain', '=', $identifier)->first();

        if ($tenant) {
            return $next($request);
        }
        return abort(404);
    }
}
