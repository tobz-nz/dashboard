<?php

namespace App\Http\Controllers\Api\Device;

use App\Device;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Device\ViewAllRequest;
use App\Http\Requests\Api\Device\ViewRequest;
use App\Http\Resources\DeviceResource;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Api\Device\ViewAllRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(ViewAllRequest $request)
    {
        $devices = $request->user()->devices()->paginate();

        return DeviceResource::collection($devices);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json('Not Implemented', 501);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Device $device
     * @return \Illuminate\Http\Response
     */
    public function show(ViewRequest $request, Device $device)
    {
        return new DeviceResource($device);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Device $device
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Device $device)
    {
        return response()->json('Not Implemented', 501);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Device $device
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Device $device)
    {
        return response()->json('Not Implemented', 501);
    }
}
