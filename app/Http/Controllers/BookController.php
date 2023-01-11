<?php

namespace App\Http\Controllers;

use App\Models\Book;

class BookController extends Controller
{
    public function getAll()
    {
        $books = Book::all();

        return view('books', ['books' => $books]);
    }
}
