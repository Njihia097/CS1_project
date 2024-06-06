<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Fortify\CreateNewEditor;


class Admin_EditorController extends Controller
{
    protected $createNewEditor;

    // Inject CreateNewEditor action
    public function __construct(CreateNewEditor $createNewEditor)
    {
        $this->createNewEditor = $createNewEditor;
    }

    public function view (Request $request) {
        return view('admin.register-editor');
    }

    public function store(Request $request)
{
    \Log::info('Store method called with data: ', $request->all());
    try {
        // Call the CreateNewEditor action's create method, passing the form data to it
        $this->createNewEditor->create($request->all());
        \Log::info('Editor created successfully.');

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Editor registered successfully.');
    } catch (\Exception $e) {
        \Log::error('Error creating editor: ', ['error' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Failed to register editor.');
    }
}

}


