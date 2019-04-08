<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->user);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'password' => 'string|min:8|nullable',
            'preferences' => 'array',
            'preferences.email_alerts' => 'boolean|nullable',
            'preferences.push_alerts' => 'boolean|nullable',
        ];
    }
}
