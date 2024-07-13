<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Artist;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.userpage');
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
