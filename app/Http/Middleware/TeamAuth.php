<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeamAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if(!session()->has('team_logged_in')){
            return redirect()->route('team.login');
        }

        return $next($request);
    }
}