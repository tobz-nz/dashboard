<?php

namespace App\Http\Controllers;

use App\Http\Requests\Device\CreateRequest;
use Illuminate\Http\Request;

class SetupController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        return view('setup', compact('user'));
    }

    public function store(CreateRequest $request)
    {
        $device = new Device($request->validated());

        return $device;
    }
}
