<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;

    protected $table = 'reactions';
    protected $fillable = [
        'user_id', 'content_id', 'chapter_id', 'type'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function content()
    {
        return $this->belongsTo(Content::class);
    }
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

}
