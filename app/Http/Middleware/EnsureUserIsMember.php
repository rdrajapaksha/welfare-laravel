<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsMember
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user === null) {
            $locale = $request->route('locale');

            if (! is_string($locale) || ! in_array($locale, config('hla.locales'), true)) {
                $locale = (string) config('hla.default_locale');
            }

            return redirect()->guest(route('login', ['locale' => $locale]));
        }

        if (! $user->is_active) {
            abort(403, (string) d('auth.inactiveAccount'));
        }

        return $next($request);
    }
}
