<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class SearchRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
        if(\Auth::user()->isAdmin()){
            return true;
        }
        return false;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'region'=>'regex:/^[-0-9a-zA-Z\s\.]+$/',
            'code'=>'regex:/^[-0-9a-zA-Z\s\.\']+$/'
		];
	}

}
