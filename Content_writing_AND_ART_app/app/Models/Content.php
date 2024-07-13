<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Usamamuneerchaudhary\Commentify\Traits\Commentable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Content extends Model
{
    use HasFactory;
    use Commentable;

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
        'IsPublished',
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
    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class, 'content_id');
    }
}
