<?php

namespace App\Http\Controllers;

use App\Service\BooksRepository;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public static function getResults(Request $request)
    {
        $books = BooksRepository::search($request->get('query'));

        return view('booksList', ['books' => $books]);
    }
}
