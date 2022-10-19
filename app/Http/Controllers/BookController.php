<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public static function create(Request $request)
    {
        Book::create($request->all());

        return 'success';
    }

    public static function getAll()
    {
        $books = Book::all();

        return view('books', ['books' => $books]);
    }
}
