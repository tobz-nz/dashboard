<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManifestController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show()
    {
        return response(view('manifest'))
            ->header('Content-Type', 'application/manifest+json');
    }
}
