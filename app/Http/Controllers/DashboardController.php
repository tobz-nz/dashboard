<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->user()->devices()->count() === 1) {
            $device = $request->user()->devices()->first();
            return redirect()
                ->route('devices.show', $device);
        }

        return view('dashboard', [
            'heading' => 'Trends',
        ]);
    }
}
