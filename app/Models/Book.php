<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    protected $fillable = [
        'title',
        'book_category_id',
        'description',
        'count',
        'pdf_file',
        'book_cover',
        'users_id_created',
    ];

    public function category()
    {
        return $this->belongsTo(BookCategory::class, 'book_category_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'users_id_created');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id_created', 'id');
    }
}
