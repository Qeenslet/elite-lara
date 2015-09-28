<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class planetExtrasAddRequest extends Request {

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
			'mass'=>'required|numeric',
            'radius'=>'required|numeric',
            'temperature'=>'required|numeric',
            'pressure'=>'required|numeric',
            'ice'=>'numeric',
            'rock'=>'numeric',
            'metal'=>'numeric',
            'orbP'=>'required|numeric',
            'mAxis'=>'required|numeric',
            'ecce'=>'required|numeric',
            'incl'=>'required|numeric',
            'peri'=>'required|numeric',
            'rotP'=>'required|numeric',
            'aTilt'=>'required|numeric',
            'volcanism'=>'required|numeric',
            'atm_type'=>'required|numeric',
            'amm'=>'numeric',
            'oxy'=>'numeric',
            'nit'=>'numeric',
            'arg'=>'numeric',
            'hel'=>'numeric',
            'wat'=>'numeric',
            'hyd'=>'numeric',
            'sud'=>'numeric',
            'cad'=>'numeric',
            'irn'=>'numeric',
            'met'=>'numeric',
            'neo'=>'numeric',
            'sil'=>'numeric',
            'price'=>'numeric',
		];
	}

}
