<?php

namespace App\Service;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

class BooksRepository implements SearchRepository
{
    public function search(string $query = ''): Collection
    {
        return Book::query()
            ->where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->get();
    }
}
