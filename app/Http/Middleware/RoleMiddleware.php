<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Vérifier si l'utilisateur est authentifié
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Vérifier si l'utilisateur a le rôle requis
        if ($user->role !== $role) {
            // Rediriger vers le dashboard approprié selon le rôle de l'utilisateur
            switch ($user->role) {
                case 'etudiant':
                    return redirect()->route('etudiant.dashboard');
                case 'comptable':
                    return redirect()->route('comptable.dashboard');
                case 'admin':
                    return redirect()->route('administration.dashboard');
                default:
                    return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
