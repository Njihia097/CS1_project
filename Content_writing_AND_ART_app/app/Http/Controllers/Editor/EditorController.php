<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditorController extends Controller
{
    public function dashboard (Request $request) {
        return view('editor.dashboard');
    }
}
