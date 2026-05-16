<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GpsTrackingController extends Controller
{
    /**
     * Display GPS tracking dashboard
     */
    public function index()
    {
        return view('admin.gps-tracking.index');
    }

    /**
     * Show specific trip GPS data
     */
    public function showTrip($tripId)
    {
        return view('admin.gps-tracking.trip', compact('tripId'));
    }
}