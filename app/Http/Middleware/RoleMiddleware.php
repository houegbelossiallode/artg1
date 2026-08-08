<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $userProfile = $request->user()->profil;

        if (!$userProfile || !in_array($userProfile->nom, $roles)) {
            // Redirect based on user's actual role to prevent loop or stuck page
            if ($userProfile) {
                if ($userProfile->nom === 'administrateur') {
                    return redirect()->route('dashboard.admin')->with('error', 'Vous n\'avez pas accès à cette section.');
                } elseif ($userProfile->nom === 'professeur') {
                    return redirect()->route('dashboard.professeur')->with('error', 'Vous n\'avez pas accès à cette section.');
                } elseif ($userProfile->nom === 'apprenant') {
                    return redirect()->route('dashboard.apprenant')->with('error', 'Vous n\'avez pas accès à cette section.');
                }
            }
            return redirect('/')->with('error', 'Accès non autorisé.');
        }

        return $next($request);
    }
}
