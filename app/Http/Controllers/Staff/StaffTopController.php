<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;

class StaffTopController extends Controller
{
    function index()
    {
        return view('staff.top');
    }
}
