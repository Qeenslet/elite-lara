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
    protected $localeDir;

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

        switch(\App::getLocale())
        {
            case 'ru':
                $this->localeDir = 'ru.';
                break;
            default:
                $this->localeDir = '';
        }
	}

    public function getRegister()
    {
        return view($this->localeDir.'auth.register');
    }

    public function getLogin()
    {
        return view($this->localeDir.'auth.login');
    }

    public function postRegister(Request $request)
    {
        $validator = $this->registrar->validator($request->all());

        if ($validator->fails())
        {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $this->registrar->create($request->all());

        return redirect('auth/before');
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
            return redirect('/')->with('loginfo', \App\Myclasses\Response::requestResult('confirm'));
        }
        else return redirect('/')->with('loginfo', \App\Myclasses\Response::requestResult('unconfirm'));
    }

    public function getBefore(){
        return view($this->localeDir.'auth.before');
    }
    protected function getFailedLoginMessage()
    {
        return \App\Myclasses\Response::requestResult('faillogin');
    }

}
