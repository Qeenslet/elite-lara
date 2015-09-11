<?php namespace App\Http\Middleware;

use Auth;
use Closure;

class CabinetProtector {

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
            if($request->user()->mayEnterCabinet()) {
                if (!$request->user()->hasLocale(\App::getLocale())) $request->user()->addLocale(\App::getLocale());
                return $next($request);
            }
        }
        return redirect('/');
	}

}
