<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        # code...
    }

    public function destroy(Request $request)
    {
        # code...
    }
}
