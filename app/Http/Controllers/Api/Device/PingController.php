<?php

namespace App\Http\Controllers\Api\Device;

use App\Device;
use App\Http\Controllers\Controller;
use App\Http\Requests\Device\PingRequest;
use App\Http\Resources\DeviceResource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PingController extends Controller
{
    /**
     * Tell the
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PingRequest $request, Device $device)
    {
        $device->update(['last_seen_at' => new Carbon]);

        return new DeviceResource($device);
    }
}