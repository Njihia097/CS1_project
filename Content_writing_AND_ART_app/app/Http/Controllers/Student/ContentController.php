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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


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

        // If the content is a chapter, create an entry in the chapter table
        if ($content->IsChapter) {
            $nextChapterNumber = $this->getNextChapterNumber($content->ContentID);
            $chapterTitle = 'Part ' . $this->numberToWord($nextChapterNumber);
            Chapter::create([
                'ContentID' => $content->ContentID,
                'ChapterNumber' => $nextChapterNumber,
                'Title' => $chapterTitle,  
            ]);
        }

        // Redirect to text formatting form
        return redirect()->route('student.editContent', $content->ContentID)->with('success', 'Content created successfully.');
       


        }catch(Exception $e) {
            Log::error('Failed to create content:'. $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create content. Please try again');
        }

    }

    public function edit($id)
    {
        $content = Content::findOrFail($id);
        $chapterTitle = null;
    
        if ($content->IsChapter) {
            $chapter = Chapter::where('ContentID', $content->ContentID)->first();
            if ($chapter) {
                $chapterTitle = $chapter->Title; // Correct field name should be Title
            }
        }
    
        return view('student.editContent', compact('content', 'chapterTitle'));
    }
    
    
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content_delta' => 'required|string',
            'action' => 'required|string|in:save,publish',
            'chapter_title' => 'nullable|string|max:255',
        ]);
    
        try {
            $content = Content::findOrFail($id);
            $content->Title = $request->title;
    
            // Parse the JSON content delta
            $contentDelta = json_decode($request->content_delta, true);
    
            // Extract pure text and media/embedded content
            $pureText = $this->extractPureText($contentDelta);
            $mediaContent = json_encode($this->extractMediaContent($contentDelta));
    
            // Generate file paths
            $textFilePath = 'content/text/' . Str::uuid() . '.txt';
            $mediaFilePath = 'content/media/' . Str::uuid() . '.json';
    
            // Store files
            Storage::disk('local')->put($textFilePath, $pureText);
            Storage::disk('local')->put($mediaFilePath, $mediaContent);
    

    
            if ($content->IsChapter) {
                // Update the existing chapter
                $chapter = Chapter::where('ContentID', $content->ContentID)->first();
                if ($chapter) {
                    $chapter->Title = $request->chapter_title ?: 'Part ' . $this->numberToWord($chapter->ChapterNumber);
                    $chapter->Body = $textFilePath;
                    $chapter->content_delta = $mediaFilePath;
                    $chapter->save();
                }
            } else {
                  // Save file paths in the database
                $content->ContentBody = $textFilePath;
                $content->content_delta = $mediaFilePath;
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

    private function extractPureText(array $contentDelta)
    {
        $pureText = '';
        foreach ($contentDelta['ops'] as $op) {
            if (isset($op['insert']) && is_string($op['insert'])) {
                $pureText .= $op['insert'];
            }
        }
        return $pureText;
    }

    private function extractMediaContent(array $contentDelta)
    {
        $mediaContent = [];
        foreach ($contentDelta['ops'] as $op) {
            if (isset($op['insert']) && !is_string($op['insert'])) {
                $mediaContent[] = $op;
            }
        }
        return $mediaContent;
    }

    public function showContentDetails (Request $request) 
    {
        
        return view('student.contentDetails');

    }

    
}
