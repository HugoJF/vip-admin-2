<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'title'       => 'required|string',
			'duration'    => 'required|numeric|min:0|max:180',
			'cost'        => 'required|numeric|min:0',
			'discount'    => 'required|numeric|min:0|max:1',
			'description' => 'required|string',
		];
	}
}
