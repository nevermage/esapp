<?php

namespace App\Http\Controllers;

use App\Service\BooksRepository;
use App\Service\SearchRepository;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function getResults(Request $request, SearchRepository $repository)
    {
//        $repository = new BooksRepository();
        $books = $repository->search($request->get('query'));

        return view('booksList', ['books' => $books]);
    }
}
