<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CategoryContent;
use Illuminate\Http\Request;


class ContentController extends Controller
{
    public function view (Request $request)
    {
        $categories = CategoryContent::all();
        return view('student.createContent', compact('categories'));
    }
}
