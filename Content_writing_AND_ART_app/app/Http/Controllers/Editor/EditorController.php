<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryContent;
use Illuminate\Validation\ValidationException;

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

    

}
