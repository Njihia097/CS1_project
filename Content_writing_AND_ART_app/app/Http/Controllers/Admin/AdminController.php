<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function adminHome(Request $request)
    {
        return view('admin.adminHome');
    }

    
}
