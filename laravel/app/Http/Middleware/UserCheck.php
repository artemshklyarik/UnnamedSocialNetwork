<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserCheck
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
        $requestUserId = $request->id;
        $checkUser = User::find($requestUserId);

        $authUserID = Auth::user()->id;

        if ($checkUser === NULL || $authUserID == $requestUserId) {
            return redirect('/');
        }

        return $next($request);
    }
}
