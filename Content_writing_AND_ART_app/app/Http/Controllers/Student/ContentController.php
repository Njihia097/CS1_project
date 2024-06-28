<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CategoryContent;
use App\Models\Chapter;
use Exception;
use Illuminate\Http\Request;
use App\Models\Content;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Storage;


class ContentController extends Controller
{
    public function view (Request $request)
    {
        $categories = CategoryContent::all();
        return view('student.Content-setup', compact('categories'));
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
            'Description' => $request->description,
            'ContentBody' => null,
            'IsChapter' => $request->has('is_chapter'),
            'IsPublished' => false,
            'PublicationDate' => null,
            'Status' => 'draft',
            'SuspendedUntil' => null,
            'content_delta' => null,
            'keywords' => $keywords,
        ]);

        // Redirect to text formatting form
        return redirect()->route('student.editContent', $content->id);
       


        }catch(Exception $e) {
            Log::error('Failed to create content:'. $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create content. Please try again');
        }

    }

    public function edit($id)
    {
        $content = Content::findOrFail($id);
        if ($content->IsChapter) {
            $nextChapterNumber = $this->getNextChapterNumber($content->ContentID);
            $content->Title = 'Part ' . $this->numberToWord($nextChapterNumber);
        }
        return view('student.editContent', compact('content'));
    }
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content_delta' => 'required|string',
            'action' => 'required|string|in:save,publish',
        ]);
    
        try {
            $content = Content::findOrFail($id);
            $content->Title = $request->title;

            // Save content in a file
            $contentFilePath = 'content/' . $content->ContentID . '.json';
            Storage::disk('local')->put($contentFilePath, $request->content_delta);
            
            if ($content->IsChapter) {
                // Save content in the chapter table
                $chapterNumber = $this->getNextChapterNumber($content->ContentID);
                $chapter = new Chapter();
                $chapter->ContentID = $content->ContentID;
                $chapter->Title = $request->title ?: 'Part ' . $this->numberToWord($chapterNumber);
                $chapter->Body = $contentFilePath; // Save file path in Body column
                $chapter->content_delta = json_decode($request->content_delta);
                $chapter->ChapterNumber = $chapterNumber;

                $chapter->save();
            } else {
                // Save content in the content table
                $content->ContentBody = $contentFilePath; // Save file path in ContentBody column
                $content->content_delta = json_decode($request->content_delta);
                $content->Status = $request->action === 'save' ? 'draft' : 'pending';
                $content->IsPublished = $request->action === 'publish' ? true : false;
                $content->PublicationDate = $request->action === 'publish' ? now() : null;

                $content->save();
            }
    
            return redirect()->route('student.editContent', $content->ContentID)->with('success', 'Content saved successfully.');

        } catch (\Throwable $th) {

            Log::error('Failed to save Content: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to Save content');

        }
    }
    
    private function getNextChapterNumber($contentID)
    {
        $lastChapter = Chapter::where('ContentID', $contentID)->orderBy('ChapterNumber', 'desc')->first();
        return $lastChapter ? $lastChapter->ChapterNumber + 1 : 1;
    }   
    
    private function numberToWord($number)
    {
        $words = [
            0 => 'Zero', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
            6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
            11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen', 20 => 'Twenty',
            30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy',
            80 => 'Eighty', 90 => 'Ninety'
        ];


    if ($number <= 20) {
        return $words[$number];
    }

    if ($number < 100) {
        $tens = intval($number / 10) * 10;
        $units = $number % 10;
        return $words[$tens] . ($units ? '-' . $words[$units] : '');
    }

    if ($number < 1000) {
        $hundreds = intval($number / 100);
        $remainder = $number % 100;
        return $words[$hundreds] . ' Hundred' . ($remainder ? ' and ' . $this->numberToWord($remainder) : '');
    }

    return (string)$number; // For numbers 1000 and above



    }
    
}
