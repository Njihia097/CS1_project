<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    protected function authenticated (Request $request, $user) {

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('editor')) {
            return redirect()->route('editor.dashboard');
        }
        else {
            return redirect()->route('student.dashboard');
        }
    }
}

