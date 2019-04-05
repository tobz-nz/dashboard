<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $devices = $user->devices;
        $device = $devices->first();

        return view('account.index', compact('user', 'device', 'devices'));
    }

    public function edit()
    {
        # code...
    }
}
