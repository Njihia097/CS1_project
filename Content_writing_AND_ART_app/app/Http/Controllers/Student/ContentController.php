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
use App\Models\Reaction;
use Usamamuneerchaudhary\Commentify\Models\Comment;


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
            'description' => 'nullable|string|max:1000',
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
            'IsChapter' => $request->has('is_chapter') ? $request->input('is_chapter') : false,
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
        Log::info('Edit Method Called');
        Log::info('Content ID: ' . $id);
        Log::info('Request Data: ' . json_encode($request->all()));
    
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
            Log::error('Failed to retrieve content: ' . $e->getMessage());
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
    
            // Directly save the content delta
            $contentDelta = $request->content_delta;

            // Generate file path for content delta
            $deltaFilePath = 'content/delta/' . Str::uuid() . '.json';

            // Store content delta as JSON
            Storage::disk('local')->put($deltaFilePath, $contentDelta);
    
            if ($content->IsChapter) {
                // Update the existing chapter based on ChapterID
                $chapter = Chapter::where('ChapterID', $request->chapter_id)->first();
                if ($chapter) {
                    $chapter->Title = $request->chapter_title ?: 'Part ' . $this->numberToWord($chapter->ChapterNumber);
                    $chapter->Body = null;
                    $chapter->content_delta = $deltaFilePath;
                    $chapter->IsPublished = $request->action == 'publish' ? true : false;
                    $chapter->publication_date = $request->action == 'publish' ? now() : null;
                    $chapter->Status = $request->action === 'save' ? 'draft' : ($request->action === 'unpublish' ? 'draft' : 'pending');
                    $chapter->save();
                }
            } else {
                // Save file paths in the database
                $content->ContentBody = null;
                $content->content_delta = $deltaFilePath;
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
    private function getContentDelta($filePath)
    {
        return json_decode(Storage::disk('local')->get($filePath), true);
    }
    
    
    public function createNewChapter($contentId, Request $request)
    {
        Log::info('Create New Chapter Method Called');
        Log::info('Content ID: ' . $contentId);
        
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
        
        Log::info('New Chapter Created:', $newChapterDetails);
        
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
            'comments' => $chapter->comments()->count(),
            'thumbsUp' => Reaction::where('chapter_id', $chapter->ChapterID)->where('type', 'thumbs_up')->count(),
            'thumbsDown' => Reaction::where('chapter_id', $chapter->ChapterID)->where('type', 'thumbs_down')->count(),
            'ChapterID' => $chapter->ChapterID
        ];
    });

    $contentDetails = [
        'title' => $content->Title,
        'lastModified' => $content->updated_at->diffForHumans(),
        'comments' => $content->comments()->count(),
        'thumbsUp' => Reaction::where('content_id', $content->ContentID)->where('type', 'thumbs_up')->count(),
        'thumbsDown' => Reaction::where('content_id', $content->ContentID)->where('type', 'thumbs_down')->count()
    ];

    return view('student.contentDetails', compact('content', 'categories', 'selectedCategoryId', 'keywordsString', 'chapters', 'contentDetails'));
}

    
    public function getContentDetails($contentId)
    {
        $content = Content::with('chapters')->find($contentId);
        
        if (!$content) {
            Log::error("Content with ID $contentId not found");
            return response()->json(['error' => 'Content not found'], 404);
        }
    
        $chapters = $content->chapters->map(function($chapter) {
            return [
                'title' => $chapter->Title,
                'lastModified' => $chapter->updated_at->diffForHumans(),
                'ChapterID' => $chapter->ChapterID,
                'comments' => $chapter->comments()->count(),
                'thumbsUp' => Reaction::where('chapter_id', $chapter->ChapterID)->where('type', 'thumbs_up')->count(),
                'thumbsDown' => Reaction::where('chapter_id', $chapter->ChapterID)->where('type', 'thumbs_down')->count()
            ];
        });
    
        $contentDetails = [
            'title' => $content->Title,
            'lastModified' => $content->updated_at->diffForHumans(),
            'comments' => $content->comments()->count(),
            'thumbsUp' => Reaction::where('content_id', $content->ContentID)->where('type', 'thumbs_up')->count(),
            'thumbsDown' => Reaction::where('content_id', $content->ContentID)->where('type', 'thumbs_down')->count()
        ];
        Log::info('Fetched content details:', ['content' => $contentDetails, 'chapters' => $chapters]);
    
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
            'description' => 'nullable|string|max:1000',
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


    public function viewContent(Request $request, $id)
    {
        $content = Content::with(['author', 'chapters' => function($query) {
            $query->where('IsPublished', 1);
        }])->findOrFail($id);
    
        // Calculate reactions, chapter count, and comment count for the content
        if ($content->IsChapter) {
            $chapterIds = $content->chapters->pluck('ChapterID');
            $content->thumbsUpCount = Reaction::whereIn('chapter_id', $chapterIds)->where('type', 'thumbs_up')->count();
            $content->thumbsDownCount = Reaction::whereIn('chapter_id', $chapterIds)->where('type', 'thumbs_down')->count();
            $content->chapterCount = $content->chapters->count();
            $content->commentCount = Comment::whereIn('commentable_id', $chapterIds)
                                            ->where('commentable_type', 'App\Models\Chapter')
                                            ->count();
        } else {
            $content->thumbsUpCount = Reaction::where('content_id', $content->ContentID)->where('type', 'thumbs_up')->count();
            $content->thumbsDownCount = Reaction::where('content_id', $content->ContentID)->where('type', 'thumbs_down')->count();
            $content->chapterCount = 0;
            $content->commentCount = $content->comments()->count();
        }
    
        return view('publicView.contentDescription', compact('content'));
    }
    

    private function combineContent($textFilePath, $mediaFilePath)
    {
        // Retrieve stored pure text and media content
        $pureText = Storage::disk('local')->get($textFilePath);
        $mediaContent = json_decode(Storage::disk('local')->get($mediaFilePath), true);

        // Initialize the combined content with pure text
        $combinedContent = [['insert' => $pureText]];

        // Append media content
        foreach ($mediaContent as $media) {
            if (isset($media['insert'])) {
                $combinedContent[] = $media;
            }
        }

        return $combinedContent;
    }

    public function startReading($id)
    {
        $content = Content::with(['author', 'chapters' => function ($query) {
            $query->where('IsPublished', 1)->orderBy('ChapterNumber');
        }])->findOrFail($id);
    
        $relatedByCategory = $this->getRelatedContentByCategory($content->CategoryID, $content->ContentID);
        $relatedByAuthor = $this->getRelatedContentByAuthor($content->AuthorID, $content->ContentID);
        $relatedByKeywords = $this->getRelatedContentByKeywords($content->keywords, $content->ContentID);
    
        if ($content->IsChapter && $content->chapters->isNotEmpty()) {
            $firstChapter = $content->chapters->first();
            $combinedContentDelta = $this->getContentDelta($firstChapter->content_delta);
            return view('publicView.startReading', compact('content', 'firstChapter', 'combinedContentDelta', 'relatedByCategory', 'relatedByAuthor', 'relatedByKeywords'));
        } else {
            $combinedContentDelta = $this->getContentDelta($content->content_delta);
            return view('publicView.startReading', compact('content', 'combinedContentDelta', 'relatedByCategory', 'relatedByAuthor', 'relatedByKeywords'));
        }
    }
    

    private function getRelatedContentByCategory($categoryId, $currentContentId)
    {
        return Content::where('CategoryID', $categoryId)
            ->where('ContentID', '!=', $currentContentId)
            ->where('IsPublished', 1)
            ->limit(5)
            ->get();
    }

    private function getRelatedContentByAuthor($authorId, $currentContentId)
    {
        return Content::where('AuthorID', $authorId)
            ->where('ContentID', '!=', $currentContentId)
            ->where('IsPublished', 1)
            ->limit(5)
            ->get();
    }

    private function getRelatedContentByKeywords($keywords, $currentContentId)
    {
        // Ensure that keywords is an array
        if (is_string($keywords)) {
            $keywords = explode(',', $keywords); // Assuming keywords are stored as a comma-separated string
        }
    
        return Content::where('ContentID', '!=', $currentContentId)
            ->where('IsPublished', 1)
            ->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->orWhere('keywords', 'LIKE', "%{$keyword}%");
                }
            })
            ->limit(5)
            ->get();
    }
    


    public function viewChapter($id)
    {
        $chapter = Chapter::with('content')->where('IsPublished', 1)->findOrFail($id);
        $combinedChapterContentDelta = $this->getContentDelta($chapter->content_delta);
        
        $relatedByCategory = $this->getRelatedContentByCategory($chapter->content->CategoryID, $chapter->content->ContentID);
        $relatedByAuthor = $this->getRelatedContentByAuthor($chapter->content->AuthorID, $chapter->content->ContentID);
        $relatedByKeywords = $this->getRelatedContentByKeywords($chapter->content->keywords, $chapter->content->ContentID);
        $relatedChapters = $this->getRelatedChapters($chapter->content->ContentID, $chapter->ChapterNumber);
    
        return view('publicView.chapter', compact('chapter', 'combinedChapterContentDelta', 'relatedByCategory', 'relatedByAuthor', 'relatedByKeywords', 'relatedChapters'));
    }
    

    private function getRelatedChapters($contentId, $currentChapterNumber)
    {
        return Chapter::where('ContentID', $contentId)
            ->where('ChapterNumber', '!=', $currentChapterNumber)
            ->where('IsPublished', 1)
            ->orderBy('ChapterNumber')
            ->limit(5)
            ->get();
    }

    private function renderCombinedContent($combinedContent)
    {
        $renderedContent = '';
        foreach ($combinedContent as $op) {
            if (isset($op['insert']) && is_string($op['insert'])) {
                $renderedContent .= nl2br(e($op['insert']));
            } elseif (isset($op['insert']) && !is_string($op['insert'])) {
                $renderedContent .= $this->renderMediaContent($op['insert']);
            }
        }
        return $renderedContent;
    }

    
    private function renderMediaContent($media)
    {
        if (isset($media['image'])) {
            return '<img src="' . asset('storage/' . $media['image']) . '" alt="Image">';
        }
        // Handle other media types as needed
        return '';
    }
    
    
    
    
        

    
}
