<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticated(Request $request)
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.adminHome');

        } elseif ($user->hasRole('editor')) {
            return redirect()->route('editor.editorHome');

        } elseif ($user->hasRole('student')) {
            return redirect()->route('student.studentHome');
            
        } else {
            return redirect()->route('register');
        }
    }
}
