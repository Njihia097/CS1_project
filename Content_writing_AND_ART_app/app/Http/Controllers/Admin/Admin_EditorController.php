<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\CreateNewEditor;


class Admin_EditorController extends Controller
{
    protected $createNewEditor;

    // Inject CreateNewEditor action
    public function __construct(CreateNewEditor $createNewEditor)
    {
        $this->createNewEditor = $createNewEditor;
    }

    public function store(Request $request)
    {
        // Call the CreateNewEditor action's create method, passing the form data to it
        $this->createNewEditor->create($request->all());

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Editor registered successfully.');

    }
}


