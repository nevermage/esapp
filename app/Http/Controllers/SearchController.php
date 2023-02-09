<?php

namespace App\Http\Controllers;

use App\Service\BooksRepository;
use App\Service\ElasticsearchRepository;
use App\Service\SearchRepository;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function getResults(Request $request, SearchRepository $repository)
    {
        $books = $repository->search($request->get('query'));

        return view('booksList', ['books' => $books]);
    }

    public function compareResults(Request $request)
    {
        $query = $request->get('query');

        $booksRepository = new BooksRepository();
        $dbResults = $booksRepository->search($query);

        $elasticSearchRepository = new ElasticsearchRepository(app()->make(\Elasticsearch\Client::class));
        $esResults = $elasticSearchRepository->search($query);

        dump([
            'db' => [
                'count' => count($dbResults),
                'results' => $dbResults->toArray()
            ],
            'es' => [
                'count' => count($esResults),
                'results' => $esResults->toArray()
            ]
        ]);
    }
}
