<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory;
    protected $table = 'favorites';
    protected $primaryKey = 'FavoriteID';

    protected $fillable = [
        'UserID',
        'ContentID',
        'Title',
        'FavoriteDate',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class, 'ContentID');
    }
}
