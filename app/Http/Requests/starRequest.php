<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class starRequest extends Request {

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
            'star'=>'required|digits_between:0,18',
            'size'=>'required_if:star,0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,17,18|digits_between:0,7',
            'class'=>'required_if:star,0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,17,18|digits_between:0,9',
            'code'=>'required|max:3|alpha',
		];
	}

}
