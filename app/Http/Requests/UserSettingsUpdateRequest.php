<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSettingsUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'          => 'email',
            'tradelink'      => 'string',
            'name'           => 'string',
            'terms'          => 'boolean',
            'hidden_flags'   => 'boolean',
            'affiliate_code' => 'string|min:3|max:50',
        ];
    }
}
