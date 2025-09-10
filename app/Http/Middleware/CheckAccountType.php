<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   // app/Http/Middleware/CheckAccountType.php
public function handle($request, Closure $next, $type)
{
    $user = $request->user();

    $hasAccount = match($type) {
        'etudiant' => $user->etudiant !== null,
        'admin' => $user->administrateur !== null,
        'comptable' => $user->comptable !== null,
        default => false
    };

    if (!$hasAccount) {
        abort(403, "Vous n'avez pas accès à cette section");
    }

    return $next($request);
}
}
