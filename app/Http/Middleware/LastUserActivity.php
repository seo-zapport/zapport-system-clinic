<?php

namespace App\Http\Middleware;

use Auth;
use Cache;
use Closure;
use Carbon\Carbon;

class LastUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = auth()->user();
            $expiresAt = now()->addMinutes(59);
            if ($user != null) {
                foreach ($user->roles as $uRole) {
                    if ($uRole->role === 'doctor' || $uRole->role === 'nurse') {
                        Cache::add('user-is-online-'. $uRole->pivot->user_id, true, $expiresAt);
                    }
                }
            }
        }
        return $next($request);
    }
}
