<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsPetugas
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless($request->user()?->role === User::ROLE_PETUGAS, 403);

        return $next($request);
    }
}
