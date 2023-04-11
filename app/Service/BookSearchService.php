<?php

namespace App\Service;

use App\Models\Book;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class BookSearchService implements SearchInterface
{
    /** @var Client */
    private $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function search(string $query = ''): Collection
    {
        $items = $this->getElasticResults($query);

        return $this->buildCollection($items);
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

    private function buildCollection(array $items): Collection
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');

        return Book::findMany($ids);
    }
}
