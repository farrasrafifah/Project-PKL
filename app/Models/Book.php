<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'genre_id',
        'title',
        'slug',
        'synopsis',
        'status',
        'price',
        'reviewed_by',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class)->orderBy('chapter_number');
    }

    public function reviews()
    {
        return $this->hasMany(ManuscriptReview::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
