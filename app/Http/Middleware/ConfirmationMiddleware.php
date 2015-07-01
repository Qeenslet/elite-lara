<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ConfirmationMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        if(Auth::check()) {
            if ($request->user()->confirmed == 'confirmacion ha pasado') {
                return $next($request);
            }
        }
        return redirect('/');
	}

}
