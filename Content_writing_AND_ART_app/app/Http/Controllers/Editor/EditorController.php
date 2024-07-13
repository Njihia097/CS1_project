<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryContent;

class EditorController extends Controller
{
    public function editorHome (Request $request) {
        return view('editor.editorHome');
    }
    public function showCategories (Request $request)
    {
        // Fetch categories with pagination (5 per page)
        $categories = CategoryContent::paginate(5);
        return view('editor.categoryManage', compact('categories'));
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

}
