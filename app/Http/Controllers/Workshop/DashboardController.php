<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    const ICON = 'fa-gauge';

    /**
     * Dashboard
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
        return response()->view('workshop.dashboard');
    }
}
