<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    const ICON = 'fa-gauge';

    public function dashboard(Request $request): Response
    {
        return response()->view('workshop.dashboard');
    }
}
