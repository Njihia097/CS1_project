<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.userpage');
    }
    
    public function view_artsale()
    {
        return view('home.artsale');
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
