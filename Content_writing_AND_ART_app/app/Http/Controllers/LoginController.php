<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;



class LoginController extends Controller
{
    public function authenticated(Request $request)
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.adminHome');

        } elseif ($user->hasRole('editor')) {
            return redirect()->route('editor.dashboard');

        } elseif ($user->hasRole('student')) {
            return redirect()->route('student.studentHome');
            
        } else {
            return redirect()->route('register');
        }
    }

}

