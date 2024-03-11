<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HandleAuthen;
use App\Models\Staff;

class StaffAuthController extends Controller
{
    use HandleAuthen;

    public function login()
    {
        return view('staff/authen/login');
    }

    public function _redirectTo()
    {   
        return redirect()->route('staff.top');
    }

    public function _guard()
    {
        return 'staff';
    }

    public function _credentialFields()
    {
        return ['email', 'password'];
    }
}
