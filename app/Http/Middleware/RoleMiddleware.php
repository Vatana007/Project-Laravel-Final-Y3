<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $user = Auth::user();

        // If the user's role is NOT in the allowed list, block them
        if (!in_array($user->role, $roles)) {
            // If they are staff trying to access admin pages, send them to POS
            if ($user->role === 'staff') {
                return redirect()->route('pos.index')->with('error', 'Access Denied: Admin only.');
            }
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}