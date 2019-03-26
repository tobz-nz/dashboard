<?php

namespace App\Http\Controllers\Api\Device;

use App\Device;
use App\Events\MetricRecorded;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeviceMetrics\CreateRequest;
use App\Http\Resources\DeviceMetricResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MetricController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\DeviceMetrics\CreateRequest  $request
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request, Device $device): AnonymousResourceCollection
    {
        return DeviceMetricResource::collection($device->metrics->paginiate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\DeviceMetrics\CreateRequest  $request
     * @return \App\Http\Resources\DeviceMetricResource
     */
    public function store(CreateRequest $request, Device $device): DeviceMetricResource
    {
        $metric = $device->metrics()->create($request->validated());

        event(new MetricRecorded($metric));

        return new DeviceMetricResource($metric);
    }
}
