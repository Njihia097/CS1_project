<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CategoryContent;
use Exception;
use Illuminate\Http\Request;
use App\Models\Content;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ContentController extends Controller
{
    public function view (Request $request)
    {
        $categories = CategoryContent::all();
        return view('student.createContent', compact('categories'));
    }

    public function store (Request $request)
    {
        $request->validate([
            'cover_page' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:50',
            'category' => 'required|exists:category_content,CategoryID',
            'keywords' => 'required|string',
            'is_chapter' => 'sometimes|boolean',
        ]);

        try{
            
        // Manage file upload
        $coverImage = $request->file('cover_page');
        $imageName = time().'.'.$coverImage->extension();
        $coverImage->move(public_path('cover_images'), $imageName);


        //Convert keywords to JSON
        $keywords = json_encode(array_map('trim', explode(',', $request->keywords)));

        $content = Content::create ([
            'Title' => $request->title,
            'AuthorID' => Auth::id(),
            'CategoryID' => $request->category,
            'thumbnail' => $imageName,
            'ContentBody' => null,
            'IsChapter' => $request->has('is_chapter'),
            'Ispublished' => false,
            'PublicationDate' => null,
            'Status' => 'pending',
            'SuspendedUntil' => null,
            'content_delta' => null,
            'keywords' => $keywords,
        ]);

        // Redirect to text formatting form
        return redirect()->route('content.edit', $content->id);
       


        }catch(Exception $e) {
            Log::error('Failed to create content:'. $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create content. PPlease try again');
        }

    }
}
