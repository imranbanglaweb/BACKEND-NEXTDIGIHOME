<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerGroupController extends Controller
{
    /**
     * Display all customer groups
     */
    public function index()
    {
        return view('admin.customers.groups');
    }
}