<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'username' => 'required',
			'steamid'  => 'required|steamid',
			'flags'    => 'required|sm_flag',
			'note'     => 'string',
        ];
    }
}
