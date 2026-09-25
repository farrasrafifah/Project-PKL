<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ManuscriptReview extends Model
{
    protected $table = 'manuscript_reviews';
    protected $fillable = ['book_id', 'reviewer_id', 'catatan', 'keputusan'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}