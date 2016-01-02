<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class addrRequest extends Request {

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
            'one_name'=>'required_without_all:code_name,region|regex:/^[-0-9a-zA-Z\s\.\']+$/',
            'code_name'=>'required_with:region|regex:/^[-0-9a-zA-Z\s\.\+]+$/',
            'region'=>'required_with:code_name|regex:/^[-0-9a-zA-Z\s\.]+$/',
		];
	}

}
