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
            'description' => 'nullable|string|max:150',
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

        $redirectUrl = route('student.editContent', $content->ContentID);

        // If the content is a chapter, create an entry in the chapter table
        if ($content->IsChapter) {
            $nextChapterNumber = $this->getNextChapterNumber($content->ContentID);
            $chapterTitle = 'Part ' . $this->numberToWord($nextChapterNumber);
            $chapter = Chapter::create([
                'ContentID' => $content->ContentID,
                'ChapterNumber' => $nextChapterNumber,
                'Title' => $chapterTitle, 
                'IsPublished' => false,
                'publication_date' => null, 
                'Status' => 'draft',
            ]);
            $redirectUrl .= '?chapterId=' . $chapter->ChapterID;
        }

        // Redirect to text formatting form
        return redirect($redirectUrl)->with('success', 'Content set up successfully.');
       


        }catch(Exception $e) {
            Log::error('Failed to create content:'. $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create content. Please try again');
        }

    }

    public function edit($id, Request $request)
    {
        \Log::info('Edit Method Called');
        \Log::info('Content ID: ' . $id);
        \Log::info('Request Data: ' . json_encode($request->all()));
    
        $content = Content::findOrFail($id);
        $chapterTitle = null;
        $chapterContent = null;
        $chapterId = $request->input('chapterId');
    
        try {
            if ($content->IsChapter || $chapterId) {
                $chapter = Chapter::where('ChapterID', $chapterId)->first();
                if ($chapter) {
                    $chapterTitle = $chapter->Title;
                    $chapterContent = [
                        'body' => $chapter->Body ? Storage::disk('local')->get($chapter->Body) : '',
                        'content_delta' => $chapter->content_delta ? Storage::disk('local')->get($chapter->content_delta) : ''
                    ];
                }
            } else {
                $contentBody = $content->ContentBody ? Storage::disk('local')->get($content->ContentBody) : '';
                $contentDelta = $content->content_delta ? Storage::disk('local')->get($content->content_delta) : '';
                $chapterContent = [
                    'body' => $contentBody,
                    'content_delta' => $contentDelta
                ];
            }
        } catch (Exception $e) {
            \Log::error('Failed to retrieve content: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to retrieve content');
        }
    
        return view('student.editContent', compact('content', 'chapterTitle', 'chapterContent', 'chapterId'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content_delta' => 'required|string',
            'action' => 'required|string|in:save,publish,unpublish',
            'chapter_title' => 'nullable|string|max:255',
            'chapter_id' => 'nullable|integer|exists:chapter,ChapterID' // Update table name here
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
                // Update the existing chapter based on ChapterID
                $chapter = Chapter::where('ChapterID', $request->chapter_id)->first();
                if ($chapter) {
                    $chapter->Title = $request->chapter_title ?: 'Part ' . $this->numberToWord($chapter->ChapterNumber);
                    $chapter->Body = $textFilePath;
                    $chapter->content_delta = $mediaFilePath;
                    $chapter->IsPublished = $request->action == 'publish' ? true : false;
                    $chapter->publication_date = $request->action == 'publish' ? now() : null;
                    $chapter->Status = $request->action === 'save' ? 'draft' : ($request->action === 'unpublish' ? 'draft' : 'pending');
                    $chapter->save();
                }
            } else {
                // Save file paths in the database
                $content->ContentBody = $textFilePath;
                $content->content_delta = $mediaFilePath;
                $content->Status = $request->action === 'save' ? 'draft' : ($request->action === 'unpublish' ? 'draft' : 'pending');
                $content->IsPublished = $request->action === 'publish' ? true : false;
                $content->PublicationDate = $request->action === 'publish' ? now() : null;
    
                $content->save();
            }
    
            $redirectUrl = route('student.editContent', ['id' => $content->ContentID]);
            if ($request->has('chapter_id')) {
                $redirectUrl .= '?chapterId=' . $request->chapter_id;
            }
    
            return redirect($redirectUrl)->with('success', 'Content saved successfully.');
        } catch (\Throwable $th) {
            Log::error('Failed to save Content: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to Save content');
        }
    }
    
    
    public function createNewChapter($contentId, Request $request)
    {
        \Log::info('Create New Chapter Method Called');
        \Log::info('Content ID: ' . $contentId);
        
        $content = Content::findOrFail($contentId);
        
        $nextChapterNumber = $this->getNextChapterNumber($content->ContentID);
        $chapterTitle = 'Part ' . $this->numberToWord($nextChapterNumber);
    
        $chapter = Chapter::create([
            'ContentID' => $content->ContentID,
            'ChapterNumber' => $nextChapterNumber,
            'Title' => $chapterTitle,
            'IsPublished' => false,
            'publication_date' => null,
            'Status' => 'draft',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    
        $newChapterDetails = [
            'title' => $chapter->Title,
            'lastModified' => $chapter->updated_at->diffForHumans(),
            'chapterId' => $chapter->ChapterID,
            'comments' => 0,
            'thumbsUp' => 0,
            'thumbsDown' => 0
        ];
        
        \Log::info('New Chapter Created:', $newChapterDetails);
        
        return response()->json($newChapterDetails);
    }

    public function destroy($id)
    {
        Log::info('Destroy Method Called');
        Log::info('Content ID: ' . $id);
        try {
            $content = Content::findOrFail($id);
    
            if ($content->IsChapter) {
                return response()->json(['error' => 'Cannot delete chapter-wise content via this method.'], 400);
            }
    
            $content->delete();
            return redirect()->route('student.home.content')->with('success', 'Content deleted successfully.');
        } catch (Exception $e) {
            Log::error('Failed to delete content: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete content. Please try again.');
        }
    }
    
    public function destroyChapter($contentId, $chapterId)
    {
        Log::info('DestroyChapter Method Called');
        Log::info('Content ID: ' . $chapterId);
        try {
            $chapter = Chapter::where('ContentID', $contentId)->where('ChapterID', $chapterId)->firstOrFail();
            $chapter->delete();
    
            return response()->json(['success' => 'Chapter deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Failed to delete chapter: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete chapter. Please try again.'], 500);
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

 public function showContentDetails(Request $request, $contentId)
{
    $content = Content::with('chapters')->findOrFail($contentId);
    $categories = CategoryContent::all();
    $selectedCategoryId = $content->CategoryID;

    // Convert JSON keywords back to comma-separated string
    $keywords = json_decode($content->keywords, true);
    $keywordsString = implode(', ', $keywords);

    $chapters = $content->chapters->map(function($chapter) {
        return [
            'title' => $chapter->Title,
            'lastModified' => $chapter->updated_at->diffForHumans(),
            'comments' => 5, // Dummy data
            'thumbsUp' => 10, // Dummy data
            'thumbsDown' => 3, // Dummy data
            'views' => 4, // Dummy data for views
            'likes' => 6 // Dummy data for likes
        ];
    });

    $contentDetails = [
        'title' => $content->Title,
        'lastModified' => $content->updated_at->diffForHumans(),
        'comments' => 5, // Dummy data
        'thumbsUp' => 10, // Dummy data
        'thumbsDown' => 3 // Dummy data
    ];

    return view('student.contentDetails', compact('content', 'categories', 'selectedCategoryId', 'keywordsString', 'chapters', 'contentDetails'));
}

    
    public function getContentDetails($contentId)
    {
        $content = Content::with('chapters')->find($contentId);
        
        if (!$content) {
            \Log::error("Content with ID $contentId not found");
            return response()->json(['error' => 'Content not found'], 404);
        }
    
        $chapters = $content->chapters->map(function($chapter) {
            return [
                'title' => $chapter->Title,
                'lastModified' => $chapter->updated_at->diffForHumans(),
                'ChapterID' => $chapter->ChapterID,
                'comments' => 5, // Dummy data
                'thumbsUp' => 10, // Dummy data
                'thumbsDown' => 3 // Dummy data
            ];
        });
    
        $contentDetails = [
            'title' => $content->Title,
            'lastModified' => $content->updated_at->diffForHumans(),
            'comments' => 5, // Dummy data
            'thumbsUp' => 10, // Dummy data
            'thumbsDown' => 3 // Dummy data
        ];
        \Log::info('Fetched content details:', ['content' => $contentDetails, 'chapters' => $chapters]);
    
        return response()->json([
            'content' => $contentDetails,
            'chapters' => $chapters
        ]);
    }
     


    public function saveContentDetails (Request $request, $contentId)
    {
        $content = Content::findOrFail($contentId);


        $request->validate([
            'cover_page' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:150',
            'category' => 'required|exists:category_content,CategoryID',
            'keywords' => 'required|string',
            'is_chapter' => 'sometimes|boolean',
        ]);

        try {
            // Manage file upload
            if($request->hasFile('cover_page')) {
                //delete the old thumbnail if it exists
                if ($content->thumbnail && file_exists(public_path('cover_images/' . $content->thumbnail))) {
                    unlink(public_path('cover_images/' . $content->thumbnail));
                }

                $coverImage = $request->file('cover_page');
                $imageName = time().'.'.$coverImage->extension();
                $coverImage->move(public_path('cover_images'), $imageName);
                $content->thumbnail = $imageName;
            }

            // Convert keywords to JSON
            $keywords = json_encode(array_map('trim', explode(',', $request->keywords)));

            $content->Title = $request->title;
            $content->CategoryID = $request->category;
            $content->Description = $request->description;
            $content->keywords = $keywords;

            $content->save();


            return redirect()->route('student.contentDetails', ['content' => $contentId])->with('success', 'Content details updated successfully.');
        } catch (Exception $e) {
            Log::error('Failed to update content: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update content. Please try again.');
        }
    }

    public function viewContent (Request $request) 
    {
        return view('publicView.contentView');

    }
        

    
}
