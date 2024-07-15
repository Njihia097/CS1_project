<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\CategoryContent;
use App\Models\Reaction;
use Illuminate\Support\Facades\DB;
use Usamamuneerchaudhary\Commentify\Models\Comment;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;


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
    public function showReadingList (Request $request) 
    {
        $favorites = Favorite::with(['content.reactions', 'content.comments'])->where('UserID', Auth::id())->get();
        return view('student.home.readingList', compact('favorites'));
    }
    public function showArtwork (Request $request) 
    {
        return view('student.home.artWork');
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

        $contents = $query->orderBy('created_at','desc')->get();

            

    // Calculate reactions, chapter count, and comment count for each content
    foreach ($contents as $content) {
        if ($content->IsChapter) {
            $chapterIds = $content->chapters->pluck('ChapterID');
            $content->thumbsUpCount = Reaction::whereIn('chapter_id', $chapterIds)->where('type', 'thumbs_up')->count();
            $content->thumbsDownCount = Reaction::whereIn('chapter_id', $chapterIds)->where('type', 'thumbs_down')->count();
            $content->chapterCount = $content->chapters->count();
            $content->commentCount = Comment::whereIn('commentable_id', $chapterIds)
                                             ->where('commentable_type', 'App\Models\Chapter')
                                             ->count();
        } else {
            $content->thumbsUpCount = Reaction::where('content_id', $content->ContentID)->where('type', 'thumbs_up')->count();
            $content->thumbsDownCount = Reaction::where('content_id', $content->ContentID)->where('type', 'thumbs_down')->count();
            $content->chapterCount = 0;
            $content->commentCount = $content->comments()->count();
        }
    }

        //Fetch the categories associated with the student's content
        $categories = CategoryContent::whereIn('CategoryID', $contents->pluck('CategoryID'))->get();
        

        return view('student.home.content', compact('contents', 'categories'));
    }
}

