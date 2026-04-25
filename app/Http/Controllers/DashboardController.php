<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return redirect()->route(Auth::user()->dashboardRoute());
    }

    public function patient()
    {
        return view('dashboards.patient');
    }

    public function doctor()
    {
        return view('dashboards.doctor');
    }

    public function admin()
    {
        return view('dashboards.admin');
    }
}
