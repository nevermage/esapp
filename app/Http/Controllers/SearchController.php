<?php

namespace App\Http\Controllers;

use App\Service\SqlSearchService;
use App\Service\ElasticsearchService;
use App\Service\SearchInterface;
use Elasticsearch\Client;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function getResults(Request $request, SearchInterface $repository)
    {
        $query = $request->get('query') ?? '';
        $books = $repository->search($query);

        return view('booksList', ['books' => $books]);
    }

    public function compareResults(Request $request, Client $client)
    {
        $query = $request->get('query');

        $booksRepository = new SqlSearchService();
        $dbResults = $booksRepository->search($query);

        $elasticSearchRepository = new ElasticsearchService($client);
        $esResults = $elasticSearchRepository->search($query);

        dump([
            'database' => [
                'count' => count($dbResults),
                'results' => $dbResults->toArray()
            ],
            'elastica' => [
                'count' => count($esResults),
                'results' => $esResults->toArray()
            ]
        ]);
    }
}
