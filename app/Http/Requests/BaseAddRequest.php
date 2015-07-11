<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class BaseAddRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'one_name'=>'regex:/^[-0-9a-zA-Z\s\.\']+$/',
            'code_name'=>'required_if:one_name,empty|regex:/^[-0-9a-zA-Z\s\.]+$/',
            'region'=>'required_if:one_name,empty|regex:/^[-0-9a-zA-Z\s\.]+$/',
            'star'=>'required|digits_between:0,17',
            'size'=>'required_if:star,0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,17|digits_between:0,7',
            'class'=>'required_if:star,0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,17|digits_between:0,9',
            'planet'=>'digits_between:0,5',
            'distance'=>'required_if:planet,0,1,2,3,4,5|numeric',
            'mark'=>'required_if:planet,0,1,2,3,4,5|in:sin,bin,tri,qua,sat',
            'code'=>'required|max:3|alpha',
		];
	}

}
