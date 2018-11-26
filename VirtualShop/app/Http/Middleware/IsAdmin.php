<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Administrator;

class IsAdmin
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
        if (! Auth::user() ) return redirect('administration/login');

        $admin = Administrator::where('idAdministrator', '=', $request->user()['idUser'])->get();
        if (count($admin) > 0) return $next($request);
        else return redirect('/');
        // if (Auth::user() &&  Auth::user()->admin == 1) {
        //     return redirect('/administration');
        // }
        // return redirect('/administration/login');
    }
}
