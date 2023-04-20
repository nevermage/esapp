<?php

namespace App\Service;

use App\Models\Book;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;

class BookSearchService implements SearchInterface
{
    /** @var Client */
    private Client $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function search(string $query = ''): Collection
    {
        $items = $this->getElasticResults($query);

        return Book::buildCollection($items);
    }

    private function getElasticResults(string $query = ''): array
    {
        $model = new Book();

        return $this->elasticsearch->search([
            'index' => $model->getTable(),
            'type' => $model->getTable(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => ['title^5', 'genre', 'description'],
                        'query' => $query,
                        "fuzziness" => config('services.search.fuzziness'),
                    ]
                ],
            ],
            'size' => 50
        ]);
    }
}
