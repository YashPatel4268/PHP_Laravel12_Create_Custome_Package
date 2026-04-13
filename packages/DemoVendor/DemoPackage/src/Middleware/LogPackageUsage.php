<?php

namespace DemoVendor\DemoPackage\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogPackageUsage
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('DemoPackage accessed at: ' . now() . ' | URL: ' . $request->path());

        return $next($request);
    }
}