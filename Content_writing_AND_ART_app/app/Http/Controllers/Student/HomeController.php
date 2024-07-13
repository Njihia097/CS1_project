<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Artist;
use App\Models\User;
use App\Models\Content;
use Usamamuneerchaudhary\Commentify\Models\Comment;
use App\Models\Reaction;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch published contents
        $contents = Content::where('IsPublished', 1)
            ->orWhere(function ($query) {
                $query->where('IsChapter', 1)
                      ->whereHas('chapters', function ($query) {
                          $query->where('IsPublished', 1);
                      });
            })
            ->get();

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

        return view('home.userpage', compact('contents'));
    }

    public function redirect()
    {
        
        $usertype=Auth::user()->usertype;
        if($usertype=='1')
        {
            return view('admin.home');
        }
        else{
            return view('home.userpage');
        }
    }
    
    public function view_artsale()
    {
        $artist=artist::all();
        return view('home.artsale',compact('artist'));
    }


    public function view_userpage()
    {
        $artist=artist::all();
        return view('home.userpage');
    }


    public function view_blogpage()
    {
        return view('home.blogpage');
    }

    public function view_contact()
    {
        return view('home.contact');
    }



    public function view_artwork()
    {
        return view('home.postart');
    }
}
