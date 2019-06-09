<?php

namespace App\Http\Controllers\Api\Device;

use App\Device;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Device\PingRequest;
use App\Http\Resources\DeviceResource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PingController extends Controller
{
    /**
     * Tell us that this device Hardware is still alive
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PingRequest $request, Device $device)
    {
        $device->update(['last_seen_at' => new Carbon]);

        return response([], 204);
    }
}
