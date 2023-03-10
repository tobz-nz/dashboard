<?php

namespace App\Http\Controllers;

use App\Alert;
use App\Device;
use App\Http\Requests\Alert\CreateRequest;
use App\Http\Requests\Alert\DeleteRequest;
use App\Http\Requests\Alert\UpdateRequest;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Device $device)
    {
        return view('alerts.index', compact('device'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request, Device $device)
    {
        $alert = $device->alerts()->create($request->validated());

        flash('New alert added')->success();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function show(Alert $alert)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function edit(Alert $alert)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Device $device, Alert $alert)
    {
        $alert->update($request->validated());

        flash('Alert Updated')->success();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteRequest $request, Device $device, Alert $alert)
    {
        $alert->delete();

        flash('Alert Removed');

        return redirect()->back();
    }
}
