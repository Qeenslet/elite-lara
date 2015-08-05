<?php namespace App\Http\Middleware;

use Closure;

class Locator {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $ip=$_SERVER['REMOTE_ADDR'];
        $isInBase=\App\Location::where('ip', $ip)->twentyFour()->first();
        if(!$isInBase){
            $data= \SypexGeo::get($ip);
            $sData=serialize($data);
            $visitor=\App\Location::create(['ip'=>$ip, 'content'=>$sData]);
        }
        return $next($request);
	}

}
