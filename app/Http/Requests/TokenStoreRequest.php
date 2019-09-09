<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TokenStoreRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'id'         => 'required|alpha_num',
			'duration'   => 'required|numeric',
			'expires_at' => 'after:now',
		];
	}
}
