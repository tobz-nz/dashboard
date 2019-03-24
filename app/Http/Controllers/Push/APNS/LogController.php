<?php

namespace App\Http\Controllers\Push\APNS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogController extends Controller
{
    public function store(Request $request)
    {
        Log::error($request->all());
    }
}
