<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MemberMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isMember()) {
            return redirect('/')->with('error', 'Anda harus login sebagai member untuk melakukan checkout.');
        }

        return $next($request);
    }
} 