<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artist;

class ArtistController extends Controller
{
    public function create()
    {
        return view('artists.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'width' => 'required|integer|min:1',
            'height' => 'required|integer|min:1',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'keywords' => 'required|string',
            'medium' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        

        $imagePath = $request->file('image')->store('art_images', 'public');

        Artist::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'width' => $validatedData['width'],
            'height' => $validatedData['height'],
            'image_path' => $imagePath,
            'keywords' => $validatedData['keywords'],
            'medium' => $validatedData['medium'],
            'price' => $validatedData['price'],
        ]);

        return redirect()->route('artsale')->with('success', 'Art piece posted successfully!');
    }

    public function index()
    {
        $artists = Artist::all();
        return view('home.artform', compact('artists'));
    }
}
