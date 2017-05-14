<?php

namespace App\Http\Middleware;

use Closure;
use App\Invite;

class InviteMiddleware
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
        if (!$request->has('code')) {
            return redirect('auth/invite-only');
        }
        $code = $request->input('code');
        $invite = Invite::getInviteByCode($code);
        if (!$invite) {
            return redirect('auth/invite-only');
        }

        return $next($request);
    }
}
