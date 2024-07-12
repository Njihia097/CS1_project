<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Usamamuneerchaudhary\Commentify\Traits\Commentable;

class Chapter extends Model
{
    use HasFactory;
    use Commentable;

    protected $table = 'chapter';
    protected $primaryKey = 'ChapterID';
    protected $fillable = [
        'ContentID',
        'Title',
        'Body',
        'ChapterNumber',
        'IsPublished',
        'publication_date',
        'Status',
        'content_delta'
    ];
    protected $casts = [
        // Cast content_delta as an array
        'content_delta' => 'array'
    ];

    public function content()
    {
        return $this->belongsTo(Content::class, 'ContentID');
    }
}
