<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{
    //middleware voor admin - Bmedewerker

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (auth()->user()){
            if(auth()->user()->account_type == 1) {
                return $next($request);
            } else {
                return redirect('home')->with('error','you do not have admin access');
            }
        }

        return \Redirect::route('login');
    }
}
