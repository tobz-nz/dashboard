<?php

namespace App\Http\Controllers;

use App\Device;
use App\Http\Requests\Device\CreateRequest;
use App\Http\Requests\Device\DeleteRequest;
use App\Http\Requests\Device\UpdateRequest;
use App\Http\Requests\Device\ViewRequest;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return redirect()->route('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $device = new Device;
        return view('devices.create', compact('device'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $device = Device::make($request->validated());
        $device->owner()->associate($request->user());
        $device->save();

        flash('Saved')->success();

        return redirect()->route('devices.show', $device);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show(ViewRequest $request, Device $device)
    {
        return view('devices.show', compact('device'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit(Device $device)
    {
        return view('devices.edit', compact('device'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, Device $device)
    {
        $data = $request->validated();
        $data['meta'] = array_merge((array)$device->meta, $data['meta']??[]);
        $device->update($data);

        flash('Saved')->success();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DeleteRequest $request, Device $device)
    {
        $device->delete();

        flash('Deleted');

        return redirect()->route('dashboard');
    }
}
