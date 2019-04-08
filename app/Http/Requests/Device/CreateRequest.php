<?php

namespace App\Http\Requests\Device;

use App\Device;
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
        return $this->user() && $this->user()->can('create', Device::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uid' => [
                'required',
                'unique:devices,uid',
                'exists:device_uids,uid,registered_at,NULL',
            ],
            'name' => 'string|nullable',
            'color' => 'string|nullable',

            // 'place' => 'required_without:address|string',

            'address' => 'required|array',
            'address.name' => 'required_with:address|string',
            'address.city' => 'required_with:address|string',
            'address.country' => 'required_with:address|string',
            'address.household_type' => 'required|string',
            'address.latlng' => 'required_with:address|array',
            'address.latlng.lat' => 'required_with:address|numeric',
            'address.latlng.lng' => 'required_with:address|numeric',

            'household_size' => 'required|numeric|min:1',

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

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            // 'address.name.required_with' => 'asdasdas',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'uid' => 'Device Code',

            'address.household_type' => 'Property Type',
            'household_size' => 'Number of Residents',

            'dimensions' => 'Dimensions',
            'dimensions.shape' => 'Water Tank Shape',
            'dimensions.height' => 'Water Tank Height',
            'dimensions.diameter' => 'Water Tank Diameter',
            'dimensions.width' => 'Water Tank Width',
            'dimensions.depth' => 'Water Tank Depth',

            'meta.catchment' => 'Water Catchment Area',
        ];
    }
}
