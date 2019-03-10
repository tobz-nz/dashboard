<?php

namespace App\Http\Requests\Api\PushSubscription;

use Illuminate\Foundation\Http\FormRequest;
use NotificationChannels\WebPush\PushSubscription;

class DeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'endpoint' => 'required|url',
        ];
    }
}
