<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PushSubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'endpoint' => $this->endpoint,
            'key' => $this->public_key,
            'token' => $this->auth_token,
        ];
    }
}
