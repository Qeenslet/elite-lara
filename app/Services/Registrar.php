<?php namespace App\Services;

use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
        $key=csrf_token();
        $key=md5($key);
        $token = "?inf=".$key;
        //$key='3D'.$key;
        \Mail::send('emails.confirmation', compact('token', 'data'), function($message) use($data) {
            $message->from('us@example.com', 'Laravel');
            $message->to($data['email'], $data['name'])->subject('Elite-Base registration confirmation');
        } );
        return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
            'confirmed' => $key,
		]);
	}

}
