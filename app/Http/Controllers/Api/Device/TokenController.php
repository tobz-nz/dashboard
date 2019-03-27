<?php

namespace App\Http\Controllers\Api\Device;

use App\Device;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Device\Token\CreateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request, Device $device)
    {
        $device->update([
            'api_token' => Str::random(60),
            'last_seen_at' => new Carbon,
        ]);

        return response()->json([
            'api_token' => $device->api_token,
        ]);
    }
}
