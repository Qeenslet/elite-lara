<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

    protected $redirectTo = '/';

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}
    public function getConfirm(Request $request){
        $inf=$request->input('inf');
        $user=\App\User::where('confirmed', $inf)->first();
        if($user) {
            $user->confirmed='confirmacion ha pasado';
            $user->save();
            \Auth::login($user);
            $zeroPoints=['stars'=>0, 'planets'=>0, 'points'=>0];
            $points=new \App\Point($zeroPoints);
            $user->points()->save($points);
            $user->roles()->attach(1);
            return redirect('/')->with('loginfo', 'Ваш email подтвержден!');
        }
        else return redirect('/')->with('loginfo', 'Произошел сбой. Ваш email не был подтвержден!');
    }

    public function getBefore(){
        return view('auth.before');
    }
    protected function getFailedLoginMessage()
    {
        return 'Что-то неправильно: либо емейл, либо пароль)';
    }

}
