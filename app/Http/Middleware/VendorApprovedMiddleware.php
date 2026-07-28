<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VendorApprovedMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->role !== 'vendor') {
            abort(403);
        }

        if ($user->vendor_status !== 'approved') {
            return redirect()->route('vendor.pending');
        }

        return $next($request);
    }
}
