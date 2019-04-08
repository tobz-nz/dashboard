<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        flash('The given data was invalid.')->error();

        parent::failedValidation($validator);
    }
}
