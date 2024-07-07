<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\CategoryContent;

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
    public function showContent(Request $request)
    {
        $studentId = auth()->id();

        // Initial query for fetching student's content
        $query = Content::where('AuthorID', $studentId);

        // Apply Type filters
        if ($request->filled('types')) {
            $types = $request->input('types');
            if (in_array('Published', $types) && in_array('Saved', $types)) {
                // Both Published and Saved checked, no additional filter needed
            } elseif (in_array('Published', $types)) {
                $query->where('IsPublished', 1);
            } elseif (in_array('Saved', $types)) {
                $query->where('IsPublished', 0);
            }
        }

        // Apply Category filters
        if ($request->filled('categories')) {
            $categories = $request->input('categories');
            $query->whereIn('CategoryID', $categories);
        }

        // Apply Content Structure filters
        if ($request->filled('structures')) {
            $structures = $request->input('structures');
            if (in_array('Chapter-wise', $structures) && in_array('Stand-alone', $structures)) {
                // Both Chapter-wise and Stand-alone checked, no additional filter needed
            } elseif (in_array('Chapter-wise', $structures)) {
                $query->where('IsChapter', 1);
            } elseif (in_array('Stand-alone', $structures)) {
                $query->where('IsChapter', 0);
            }
        }

        $contents = $query->get();

        //Fetch the categories associated with the student's content
        $categories = CategoryContent::whereIn('CategoryID', $contents->pluck('CategoryID'))->get();

        return view('student.home.content', compact('contents', 'categories'));
    }
}

