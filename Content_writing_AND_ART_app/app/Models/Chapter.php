<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $table = 'chapter';
    protected $fillables = [
        'ContentID',
        'Title',
        'Body',
        'ChapterNumber',
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