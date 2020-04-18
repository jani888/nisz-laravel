<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class RedirectNewUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(auth()->check()){
            \View::share('unreadCount', $unreadCount = \Chat::messages()->setParticipant(auth()->user())->unreadCount());
        }
        if (in_array($request->path(), ['onboarding', 'join', 'family']) || auth()->guest() || auth()->user()->family != null) {
            return $next($request);
        }
        return redirect('/onboarding');
    }
}
