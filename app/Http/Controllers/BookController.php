<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Service\BookSearchService;
use App\Service\SearchInterface;
use App\Service\SqlSearchService;
use Elasticsearch\Client;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BookController extends Controller
{

    /**
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $books = Book::all();

        return view('books', ['books' => $books]);
    }

    /**
     * @param Request $request
     * @param SearchInterface $repository
     * @return Application|Factory|View
     */
    public function search(Request $request, SearchInterface $repository): Application|Factory|View
    {
        $query = $request->get('query');
        $books = $query ? $repository->search($query) : Book::all();

        return view('booksList', ['books' => $books]);
    }


    /**
     * @param Request $request
     * @param Client $client
     * @return array[]
     */
    public function searchWithComparison(Request $request, Client $client): array
    {
        $query = $request->get('query');

        $booksRepository = new SqlSearchService();
        $dbResults = $booksRepository->search($query);

        $elasticSearchRepository = new BookSearchService($client);
        $esResults = $elasticSearchRepository->search($query);

        return [
            'database' => [
                'count' => count($dbResults),
                'results' => $dbResults->toArray()
            ],
            'elastica' => [
                'count' => count($esResults),
                'results' => $esResults->toArray()
            ]
        ];
    }
}
