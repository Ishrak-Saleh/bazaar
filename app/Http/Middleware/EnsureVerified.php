<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()->hasVerifiedEmail()) {
            return redirect()
                ->route('verification.notice')
                ->with(
                    'warning',
                    'Your email address has not been verified. Please verify your email before continuing.'
                );
        }

        return $next($request);
    }
}