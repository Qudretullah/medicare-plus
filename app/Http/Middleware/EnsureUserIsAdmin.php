<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        // Check whether the user is logged in
        if (!auth()->check()) {
            return redirect()->route('admin.login');
        }

        // Get authorized admin email from config
        $adminEmail = config('admin.email');

        // Check whether this user is the admin
        if (
            !$adminEmail ||
            strcasecmp(auth()->user()->email, $adminEmail) !== 0
        ) {
            abort(403, 'Unauthorized admin access.');
        }

        // Allow the request to continue
        return $next($request);
    }
}
