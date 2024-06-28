<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Content extends Model
{
    use HasFactory;

    protected $table = 'content';
    protected $primaryKey = 'ContentID';

    protected $fillable = [
        'Title',
        'AuthorID',
        'CategoryID',
        'thumbnail',
        'Description',
        'ContentBody',
        'IsChapter',
        'IsPubished',
        'PublicationDate',
        'Status',
        'SuspendedUntil',
        'content_delta',
        'keywords'

    ];

    protected $casts = [
    // cast content_delta and keywords as array
        'content_delta' => 'array', 
        'keywords' => 'array',
        
    ];
    public function author()
    {
        return $this->belongsTo(User::class, 'AuthorID');
    }
    public function category()
    {
        return $this->belongsTo(CategoryContent::class, 'CategoryID');
    }
    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'ContentID');
    }
}