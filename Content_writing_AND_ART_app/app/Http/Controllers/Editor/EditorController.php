<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryContent;
use Illuminate\Validation\ValidationException;
use App\Models\Content;
use App\Models\User;
use App\Events\ContentStatusUpdated;
use App\Notifications\ContentFlaggedNotification;
use App\Notifications\ContentStatusUpdateNotification;

class EditorController extends Controller
{
    public function editorHome (Request $request) {
        return view('editor.editorHome');
    }
    public function showCategories (Request $request)
    {
        // Fetch categories with pagination (5 per page)
        $categories = CategoryContent::paginate(5);
        return view('editor.manageCategory', compact('categories'));
    }
    public function update(Request $request, $id)
    {
        $category = CategoryContent::findOrFail($id);
        $category->update([
            'CategoryName' => $request->CategoryName,
            'Description' => $request->Description
        ]);
        

        return response()->json(['success' => true]);
    }
    public function store(Request $request)
    {
        try{

            $request->validate([
                'CategoryName' => 'required|string|max:255',
                'Description' => 'nullable|string',
            ]);
    
            $category = CategoryContent::create([
                'CategoryName' => $request->CategoryName,
                'Description' => $request->Description,
            ]);
    
            return response()->json([
                'success' => true,
                'category' => $category,
            ]);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

    }
    public function destroy($id)
    {
        $category = CategoryContent::findOrFail($id);
        $category->delete();

        return response()->json(['success' => true]);
    }
    public function showManageContent(Request $request)
    {
        // Fetch published contents and chapter-wise contents with published chapters
        $contents = Content::where('IsPublished', 1)
            ->orWhere(function ($query) {
                $query->where('IsChapter', 1)
                      ->whereHas('chapters', function ($query) {
                          $query->where('IsPublished', 1);
                      });
            })
            ->with(['chapters' => function ($query) {
                $query->where('IsPublished', 1);
            }])
            ->get()
            ->map(function ($content) {
                // Check parent content status before setting it to 'pending'
                if ($content->IsChapter && $content->chapters->isNotEmpty()) {
                    if ($content->Status !== 'flagged' && $content->Status !== 'suspended' && $content->Status !== 'approved') {
                        $content->Status = 'pending';
                    }
                }
                return $content;
            });
    
        return view('editor.manageContent', compact('contents'));
    }
    

    public function updateContentStatus(Request $request, $id)
    {
        $content = Content::findOrFail($id);
        $content->update(['Status' => $request->status]);

        event(new ContentStatusUpdated($content));

        // Notify the admin if the content is flagged
        if ($request->status == 'flagged') {
            $admins = User::role('admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new ContentFlaggedNotification($content));
            }
        }

        // Notify the author about the status update
        $author = $content->author;
        $author->notify(new ContentStatusUpdateNotification($content));

        return response()->json(['success' => true]);
    }
    
    public function displayContentDetails($id)
    {
        $content = Content::with(['author', 'chapters' => function ($query) {
            $query->where('IsPublished', 1);
        }])->findOrFail($id);

        return view('editor.contentView', compact('content'));
    }


    

    

}
