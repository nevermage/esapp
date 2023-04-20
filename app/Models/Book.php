<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    use Searchable;

    protected $table = 'book';

    const GENRES = [
        'Adventure',
        'Detective',
        'Drama',
        'Fantasy'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $casts = [
        'title',
        'description',
        'genre',
        'year',
    ];
}
