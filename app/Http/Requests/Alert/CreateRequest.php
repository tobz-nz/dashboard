<?php

namespace App\Http\Requests\Alert;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->device);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'trigger' => 'required|numeric:between:1,3',
            'percent' => 'required|numeric:between:0,100',
        ];
    }
}
