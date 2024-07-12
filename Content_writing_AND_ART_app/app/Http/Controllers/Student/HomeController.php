<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Artist;
use App\Models\User;
use App\Models\Content;

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
