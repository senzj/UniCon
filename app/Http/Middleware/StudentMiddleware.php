<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StudentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and has the 'student' role
        if (Auth::check() && Auth::user()->role === 'student') {
            return $next($request);
        }

        // Redirect or abort for unauthorized access
        // abort(403, 'Unauthorized action.');
        // abort(redirect()->route('home'));

        abort(403, 'Access denied.'); // Makes it look like the user doesn't have permission to access the page
        
        return $next($request);
    }
}
