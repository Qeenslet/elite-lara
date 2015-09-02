<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class planetRequest extends Request {

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
            'planet'=>'required|digits_between:0,5',
            'distance'=>'required|numeric',
            'mark'=>'required|in:sin,bin,tri,qua,sat',
		];
	}

}
