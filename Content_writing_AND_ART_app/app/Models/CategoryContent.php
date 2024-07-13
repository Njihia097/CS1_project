<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryContent extends Model
{
    use HasFactory;

    protected $table = 'category_content';
    protected $primaryKey = 'CategoryID';

    protected $fillable =  [
        'CategoryName', 'Description'
    ];

    public function content()
    {
        return $this->hasMany(Content::class, 'CategoryID');
    }
}
