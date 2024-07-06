<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;

class StudentController extends Controller
{
    public function studentHome (Request $request) 
    {
        return view('student.studentHome');
    }

    public function showAbout (Request $request) 
    {
        return view('student.home.about');
    }
    public function showContent (Request $request) 
    {
        //Fetch content belonging to the respective student
        $studentId = auth()->id();
        $contents = Content::where('AuthorID', $studentId)->get();
        return view('student.home.content', compact('contents'));
    }
    public function showReadingList (Request $request) 
    {
        return view('student.home.readingList');
    }
    public function showArtwork (Request $request) 
    {
        return view('student.home.artwork');
    }
}
