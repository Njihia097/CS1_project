<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function studentHome (Request $request) {
        return view('student.studentHome');
    }

    public function showAbout (Request $request) {
        return view('student.home.about');
    }
    public function showStories (Request $request) {
        return view('student.home.stories');
    }
    public function showReadingList (Request $request) {
        return view('student.home.readingList');
    }
    public function showArtwork (Request $request) {
        return view('student.home.artwork');
    }
}
