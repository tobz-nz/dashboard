<?php

namespace App\Http\Requests\Device;

use App\Device;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user() && $this->user()->can('update', $this->device);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string|nullable',
            'color' => 'string|nullable',

            'household_size' => 'required|numeric|min:1',

            'address' => 'array|nullable',
            'address.name' => 'required_with:address|string',
            'address.city' => 'required_with:address|string',
            'address.country' => 'required_with:address|string',
            'address.latlng' => 'required_with:address|array',
            'address.latlng.lat' => 'required_with:address|numeric',
            'address.latlng.lng' => 'required_with:address|numeric',

            'dimensions' => 'required|array',
            'dimensions.shape' => 'required_with:dimensions|string|in:rectangle,cylinder',
            'dimensions.height' => 'required_with:dimensions|numeric',
            'dimensions.diameter' => 'required_if:dimensions.shape,cylinder|numeric',
            'dimensions.width' => 'required_if:dimensions.shape,rectangle|numeric',
            'dimensions.depth' => 'required_if:dimensions.shape,rectangle|numeric',

            'meta' => 'array|nullable',
            'meta.catchment' => 'numeric|nullable',
        ];
    }
}
