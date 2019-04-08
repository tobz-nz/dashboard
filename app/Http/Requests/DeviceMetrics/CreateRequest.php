<?php

namespace App\Http\Requests\DeviceMetrics;

use App\Http\Requests\BaseRequest;

class CreateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // $this->user() is not a User but a Device
        // This is because hijacking the Auth Guard
        return $this->device->is($this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'value' => 'required|numeric',
        ];
    }
}
